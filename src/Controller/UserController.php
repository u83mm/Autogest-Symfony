<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\BuscaUsuario;
use App\Form\UserType;
use App\Form\ChangeUserPasswdType;
use App\Form\BuscaUsuarioType;
use App\Repository\UserRepository;
use App\Repository\DepartamentosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Core\Security;
use App\Service\ImageOptimizer;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
class UserController extends AbstractController
{
	private $security;
	private $imageOptimizer;
	/**
	* @var \Doctrine\Persistence\ManagerRegistry
	*/
	private $managerRegistry;

	public function __construct(Security $security, ImageOptimizer $imageOptimizer, \Doctrine\Persistence\ManagerRegistry $managerRegistry)
	{       
		$this->security = $security;
		$this->imageOptimizer = $imageOptimizer;
		$this->managerRegistry = $managerRegistry;
	}	
	
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, Request $request): Response
    {    	
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para acceder.');
			return $this->redirectToRoute('main_menu');
		}				
		
    	$offset = max(0, $request->query->getInt('offset', 0));
    	$paginator = $userRepository->getUserPaginator($offset);
    	
    	// Cálcula el valor a asignar a la variable $last para ir al último registro del listado    	    	    	
    	$last = $userRepository->getLast($paginator);
    	
        return $this->render('user/index.html.twig', [
            //'users' => $userRepository->findAll(),
            'users' => $paginator,
            'previous' => $offset - UserRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + UserRepository::PAGINATOR_PER_PAGE),
            'desde' => $offset + 1,
            'last' => $last,            
        ]);
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, DepartamentosRepository $departmentsRepository, UserPasswordHasherInterface $passwordEncoder, SluggerInterface $slugger, ValidatorInterface $validator): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para poder crear un usuario.');
			return $this->redirectToRoute('main_menu');
		}
		
        $user = new User();                  
        $form = $this->createForm(UserType::class, $user);       
        $form->handleRequest($request);                                                          
        
        // maneja los posibles errores de validación al enviar el formulario
        $errors = $validator->validate($user);
                        
        if(count($errors) > 0) {
    		$errorsString = (string) $errors;        		
			return $this->render('user/new.html.twig', [					
				'errors' => $errors,
				'user' => $user,					
				'form' => $form->createView(),					
			]);								
        }

        if ($form->isSubmitted() && $form->isValid()) {					    
        	// manage file to upload
        	$fotoFilename = $form->get('foto')->getData();
        	
        	if($fotoFilename) {
				$originalFilename = pathinfo($fotoFilename->getClientOriginalName(), PATHINFO_FILENAME);
				$safeFilename = $slugger->slug($originalFilename);
				$newFilename = $safeFilename.'-'.uniqid().'.'.$fotoFilename->guessExtension();
				
				// Si no cumple las validaciones de archivo a subir crea un array para los errores
        		$errorsValidation = [];
        		
        		// Si el formato de archivo no es el correcto, añade errores al array
        		if($fotoFilename->guessExtension() != 'png' && $fotoFilename->guessExtension() != 'jpg' && $fotoFilename->guessExtension() != 'gif') {
        			$errorsValidation[] = ['message' => 'Seleccione un archivo de imagen válido.'];        				
        		}
        		         		 
        		// Si el tamaño de archivo no es el correcto, crea array de errores     		        		
        		if($fotoFilename->getSize() > '600000') {
        			$errorsValidation[] = ['message' => 'El archivo excede el tamaño permitido.'];        				
        		}
        		
        		// Si el array de errores contiene elementos muestra los errores
        		if(count($errorsValidation) >= 1) {
        			return $this->render('user/new.html.twig', [					
						'errors' => $errorsValidation,
						'user' => $user,
						//'form_dep' => $form_dep,					
						'form' => $form->createView(),					
					]);										
        		}
				
				// Move the file to the directory where image profile are stored
				try {
					$fotoFilename->move($this->getParameter('image_profile_directory'), $newFilename);                     
                    $this->imageOptimizer->resize($this->getParameter('image_profile_directory'). "/" . $newFilename);                  
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    echo "No se ha podido subir la imagen";
                    echo $e->getMessage();
                }
                
                // updates the 'foto' property to store the image file name instead of its contents                
                $user->setFoto($newFilename);
        	}        	        	
        	
        	// encode the plain password
        	$user->setPassword(
        		$passwordEncoder->hashPassword(
        			$user,
        			$form->get('password')->getData()
        		)
        	);
        	
        	// recoge el valor del elemento "departamento" e inicializa la propiedad "departamento" de la entidad User a dicho valor
        	$departamento = $form->get('departamento')->getData();
        	
        	if($departamento) {
        		$user->setDepartamento($departamento);
        	}
        	
        	
        	// asigna un role en función del departamento
        	$rolDepartamento = $departmentsRepository->findByNombreDepartamento($departamento);
        	
        	if(count($rolDepartamento) == 1) {
        		foreach($rolDepartamento as $roles) {        			     			
        			$role[] = $roles->getRole();
        		}
        		
        		$user->setRoles($role);
        	}        	        	        	        	        	        	
        	
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            
            $this->addFlash('notice', 'Usuario creado.');			

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,            
        ]);
    }
    
    #[Route('/search', name: 'user_search', methods: ['GET', 'POST'])]
	public function search(Request $request, UserRepository $userRepository, ValidatorInterface $validator): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para acceder.');
			return $this->redirectToRoute('main_menu');
		}
		
		$buscaUsuario = new BuscaUsuario();
    	$form = $this->createForm(BuscaUsuarioType::class, $buscaUsuario);       
        $form->handleRequest($request);
        
        /* // maneja los posibles errores de validación al enviar el formulario
        $errors = $validator->validate($buscaUsuario);
                        
        if (count($errors) > 0) {
        		$errorsString = (string) $errors;        		
				return $this->render('user/search.html.twig', [					
					'errors' => $errors,
					'busca' => $buscaUsuario,					
					'form' => $form->createView(),					
				]);								
        }   */            
        
        if ($form->isSubmitted()) {
        	// Si no se han rellenado alguno de los campos del formulario arroja una aviso
		    if($buscaUsuario->getSelecciona() == "" || $buscaUsuario->getValor() == "") {
		    	$this->addFlash('warning', 'Debes rellenar los campos.');
		    	return $this->render('user/search.html.twig', [										
						'busca' => $buscaUsuario,					
						'form' => $form->createView(),					
					]);	
		    }
		    
        	$campo = $buscaUsuario->getSelecciona();
        	$valor = $buscaUsuario->getValor();         	        	
        	
        	$offset = max(0, $request->query->getInt('offset', 0));
    		$paginator = $userRepository->findByFieldValue($offset, $campo, $valor);
        	
        	if(count($paginator) > 0) {        		       		        		        		
        		return $this->render('user/search_result.html.twig', [				  				   
				    'users' => $paginator,
				    'previous' => $offset - UserRepository::PAGINATOR_PER_PAGE,
				    'next' => min(count($paginator), $offset + UserRepository::PAGINATOR_PER_PAGE),
				    'desde' => $offset + 1,
				    'campo' => $campo,
				    'valor' => $valor
				]);
        	}
        	else {
        		return $this->render('user/search_result.html.twig', [				  				   
				    'users' => '',
				    'previous' => $offset - UserRepository::PAGINATOR_PER_PAGE,
				    'next' => min(count($paginator), $offset + UserRepository::PAGINATOR_PER_PAGE),
				    'desde' => $offset + 1,
				    'campo' => $campo,
				    'valor' => $valor
				]);
        	}
        }
        
    	return $this->render('user/search.html.twig', [           
            'form' => $form,                 
        ]);                
    } 
    
	#[Route('/search/results', name: 'user_search_results', methods: ['GET'])]
    public function searchResults(UserRepository $userRepository, Request $request): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para acceder.');
			return $this->redirectToRoute('main_menu');
		}
        
    	$campo = $request->query->get('campo');
    	$valor = $request->query->get('valor'); 
        	
    	$offset = max(0, $request->query->getInt('offset', 0));
    	$paginator = $userRepository->findByFieldValue($offset, $campo, $valor);
    	
        return $this->render('user/search_result.html.twig', [           
            'users' => $paginator,
            'previous' => $offset - UserRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + UserRepository::PAGINATOR_PER_PAGE),
            'desde' => $offset + 1,
            'campo' => $campo,
		    'valor' => $valor
        ]);
    } 

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]		
    public function show(User $user, TokenInterface $token): Response
    { 
		if(!$this->security->isGranted('view', $user)) {
			$this->addFlash('warning', 'Acceso denegado.');
			
			return $this->redirectToRoute('user_show', ['id' => $token->getUser()->getId()]);
		}

        try {			
			return $this->render('user/show.html.twig', [
				'user' => $user,            
			]);

		} catch (\Throwable $th) {
			$this->addFlash('warning', $th->getMessage());
			return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
		}
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, DepartamentosRepository $departmentsRepository, SluggerInterface $slugger, UserPasswordHasherInterface $passwordEncoder, ValidatorInterface $validator): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para editar el perfil.');
			return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
		}
		
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);                               
        
        $user->setConfirmPassword($user->getPassword());
        
        // maneja los posibles errores de validación al enviar el formulario
        $errors = $validator->validate($user);
                        
        if (count($errors) > 0) {
    		$errorsString = (string) $errors;        		
			return $this->render('user/edit.html.twig', [					
				'errors' => $errors,
				'user' => $user,					
				'form' => $form->createView(),			
			]);								
        }

        if ($form->isSubmitted() && $form->isValid()) {
        	// manage file to upload
        	$fotoFilename = $form->get('foto')->getData();         	        	         	     	        	
        	
        	if($fotoFilename) {
        		// manage file to remove
		    	$filesystem = new Filesystem();
		    	$fotoToRemove = $user->getFoto();
		    	
		    	if($fotoToRemove) {		    		
		    		$filesystem->remove(['symlink', 'uploads/image_profile/' . $fotoToRemove]);
		    	}
		    	        	
				$originalFilename = pathinfo($fotoFilename->getClientOriginalName(), PATHINFO_FILENAME);																			
				$safeFilename = $slugger->slug($originalFilename);								
				$newFilename = $safeFilename.'-'.uniqid().'.'.$fotoFilename->guessExtension();										
				
				// Si no cumple las validaciones de archivo a subir crea un array para los errores
        		$errorsValidation = [];
        		
        		// Si el formato de archivo no es el correcto, añade errores al array
        		if($fotoFilename->guessExtension() != 'png' && $fotoFilename->guessExtension() != 'jpg' && $fotoFilename->guessExtension() != 'gif') {
        			$errorsValidation[] = ['message' => 'Seleccione un archivo de imagen válido.'];        				
        		}
        		         		 
        		// Si el tamaño de archivo no es el correcto, crea array de errores     		        		
        		if($fotoFilename->getSize() > '600000') {
        			$errorsValidation[] = ['message' => 'El archivo excede el tamaño permitido.'];        				
        		}
        		
        		// Si el array de errores contiene elementos muestra los errores
        		if(count($errorsValidation) >= 1) {
        			return $this->render('user/edit.html.twig', [					
						'errors' => $errorsValidation,
						'user' => $user,											
						'form' => $form->createView(),					
					]);										
        		}
				
				// Move the file to the directory where image profile are stored
				try {					
					//dd($ruta);														
                    $fotoFilename->move($this->getParameter('image_profile_directory'), $newFilename);                     
                    $this->imageOptimizer->resize($this->getParameter('image_profile_directory'). "/" . $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    echo "No se ha podido subir la imagen";
                    echo $e->getMessage();
                }
                
                // updates the 'foto' property to store the image file name
                // instead of its contents
                $user->setFoto($newFilename);
        	}        	        	
        	        	        	
        	if($form->get('departamento')->getData() != ""){
        		$user->setDepartamento($form->get('departamento')->getData());
        	}
        	
        	// recoge el valor de la propiedad "departamento"
        	$departamento = $user->getDepartamento();        	
        	
        	// asigna un role en función del departamento
        	$rolDepartamento = $departmentsRepository->findByNombreDepartamento($departamento);
        	
        	if(count($rolDepartamento) == 1) {
        		foreach($rolDepartamento as $roles) {        			     			
        			$role[] = $roles->getRole();
        		}
        		
        		$user->setRoles($role);
        	}        	        	
        	        	          	
            $this->managerRegistry->getManager()->flush();
            
            $this->addFlash(
		        'notice',
		        'El perfil ha sido actualizado!'
		    );

            return $this->redirectToRoute('user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);            
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,         
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para eliminar el perfil.');
			return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
		}
		
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/{id}/passwd', name: 'user_change_passwd', methods: ['GET', 'POST'])]
    public function changePassword(Request $request, User $user, SluggerInterface $slugger, UserPasswordHasherInterface $passwordEncoder, ValidatorInterface $validator): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para acceder.');
			return $this->redirectToRoute('main_menu');
		}
		
    	$user->setConfirmPassword($user->getPassword());
    	
		$form = $this->createForm(ChangeUserPasswdType::class, $user);
		$form->handleRequest($request);
						
		// maneja los posibles errores de validación al enviar el formulario
        $errors = $validator->validate($user);
                        
        if (count($errors) > 0) {
        		$errorsString = (string) $errors;        		
				return $this->render('user/change_password.html.twig', [					
					'errors' => $errors,
					'user' => $user,					
					'form' => $form->createView(),					
				]);								
        }
		
		if ($form->isSubmitted() && $form->isValid()) {
			// encode the plain password
        	$user->setPassword(
        		$passwordEncoder->hashPassword(
        			$user,
        			$form->get('password')->getData()
        		)
        	);
        	
        	// muestra mensaje
        	$this->addFlash(
		        'notice',
		        'Contraseña actualizada!'
		    );        	        	
        	
        	$this->managerRegistry->getManager()->flush();

             return $this->redirectToRoute('user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
		}
		
		return $this->render('user/change_password.html.twig', [
            'user' => $user,
            'form' => $form,            
        ]);
    }             
}
