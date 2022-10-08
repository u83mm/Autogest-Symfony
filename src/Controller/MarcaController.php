<?php

namespace App\Controller;

use App\Entity\Marca;
use App\Form\Marca\MarcaType;
use App\Repository\MarcaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\DBAL\Driver\PDO\Exception;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Filesystem\Filesystem;
use App\Service\ImageOptimizer;

#[Route('/marca')]
class MarcaController extends AbstractController
{
	private $security;
	private $imageOptimizer;

	public function __construct(Security $security, ImageOptimizer $imageOptimizer)
	{       
	  $this->security = $security;
	  $this->imageOptimizer = $imageOptimizer;
	}
	
    #[Route('/', name: 'marca_index', methods: ['GET'])]
    public function index(MarcaRepository $marcaRepository, ValidatorInterface $validator): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Acceso denegado.');
			return $this->redirectToRoute('main_menu');
		}
		
        return $this->render('marca/index.html.twig', [
            'marcas' => $marcaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'marca_new', methods: ['GET','POST'])]
    public function new(Request $request, ValidatorInterface $validator, SluggerInterface $slugger): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para editar el perfil.');
			return $this->redirectToRoute('marca_show', ['id' => $marca->getId()]);
		}
		
        $marca = new Marca();
        $form = $this->createForm(MarcaType::class, $marca);
        $form->handleRequest($request);
        
        // maneja los posibles errores de validación al enviar el formulario
        $errors = $validator->validate($marca);
                        
        if (count($errors) > 0) {
        		$errorsString = (string) $errors;        		
				return $this->render('marca/new.html.twig', [					
					'errors' => $errors,
					'marca' => $marca,					
					'form' => $form->createView(),					
				]);								
        }                

        if ($form->isSubmitted() && $form->isValid()) {
        	// Si no se han rellenado alguno de los campos del formulario arroja una aviso
		    if($marca->getNombre() == "") {
		    	$this->addFlash('warning', 'Debes rellenar los campos.');
		    	return $this->render('marca/new.html.twig', [										
					'marca' => $marca,					
					'form' => $form->createView(),					
				]);	
		    }
		    
        	// manage file to upload
        	$logoFilename = $form->get('logo')->getData();        	        	
        	
        	if($logoFilename) {
        		$originalFilename = pathinfo($logoFilename->getClientOriginalName(), PATHINFO_FILENAME);
        		$safeFilename = $slugger->slug($originalFilename);
        		$newFilename = $safeFilename.'-'.uniqid().'.'.$logoFilename->guessExtension();        		        		
        		
        		// Si no cumple las validaciones de archivo a subir crea un array para los errores
        		$errorsValidation = [];
        		
        		// Si el formato de archivo no es el correcto, añade errores al array
        		if($logoFilename->guessExtension() != 'png' && $logoFilename->guessExtension() != 'jpg' && $logoFilename->guessExtension() != 'gif') {
        			$errorsValidation[] = ['message' => 'Seleccione un archivo de imagen válido.'];        				
        		}
        		         		 
        		// Si el tamaño de archivo no es el correcto, crea array de errores     		        		
        		if($logoFilename->getSize() > '600000') {
        			$errorsValidation[] = ['message' => 'El archivo excede el tamaño permitido.'];        				
        		}
        		
        		// Si el array de errores contiene elementos muestra los errores
        		if(count($errorsValidation) >= 1) {
        			return $this->render('marca/new.html.twig', [					
						'errors' => $errorsValidation,
						'marca' => $marca,					
						'form' => $form->createView(),					
					]);										
        		}
        		else {
        			// Move the file to the directory where image profile are stored
					try {										
		                $logoFilename->move($this->getParameter('logo_marca_directory'), $newFilename);
		                $this->imageOptimizer->resize($this->getParameter('logo_marca_directory'). "/" . $newFilename); 
		            } catch (FileException $e) {
		                // ... handle exception if something happens during file upload
		                echo "No se ha podido subir la imagen";
		                echo $e->getMessage();
		            }
        		}        		        		        		        		
                
                // updates the 'logo' property to store the image file name instead of its contents                
                $marca->setLogo($newFilename);
        	}
        	        	
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marca);
            $entityManager->flush();
            
            $this->addFlash('notice', 'Se ha creado una nueva Marca.');

            return $this->redirectToRoute('marca_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marca/new.html.twig', [
            'marca' => $marca,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'marca_show', methods: ['GET'])]
    public function show(Marca $marca): Response
    {
        return $this->render('marca/show.html.twig', [
            'marca' => $marca,
        ]);
    }

    #[Route('/{id}/edit', name: 'marca_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Marca $marca, ValidatorInterface $validator, SluggerInterface $slugger): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para editar el perfil.');
			return $this->redirectToRoute('marca_show', ['id' => $marca->getId()]);
		}
		
        $form = $this->createForm(MarcaType::class, $marca);
        $form->handleRequest($request);
        
        // maneja los posibles errores de validación al enviar el formulario
        $errors = $validator->validate($marca);
                        
        if (count($errors) > 0) {
    		$errorsString = (string) $errors;        		
			return $this->render('marca/edit.html.twig', [					
				'errors' => $errors,
				'marca' => $marca,					
				'form' => $form->createView(),					
			]);								
        }

        if ($form->isSubmitted() && $form->isValid()) {
        	// manage file to upload
        	$logoFilename = $form->get('logo')->getData();
        	
        	if($logoFilename) {
        		// manage file to remove
		    	$filesystem = new Filesystem();
		    	$fotoToRemove = $marca->getLogo();		    			    	
		    	
		    	if($fotoToRemove) {		    		
		    		$filesystem->remove(['symlink', 'uploads/logo_marca/' . $fotoToRemove]);
		    	}
		    	        	
				$originalFilename = pathinfo($logoFilename->getClientOriginalName(), PATHINFO_FILENAME);
				$safeFilename = $slugger->slug($originalFilename);
				$newFilename = $safeFilename.'-'.uniqid().'.'.$logoFilename->guessExtension();
				
				// Si no cumple las validaciones de archivo a subir crea un array para los errores
        		$errorsValidation = [];
        		
        		// Si el formato de archivo no es el correcto, añade errores al array
        		if($logoFilename->guessExtension() != 'png' && $logoFilename->guessExtension() != 'jpg' && $logoFilename->guessExtension() != 'gif') {
        			$errorsValidation[] = ['message' => 'Seleccione un archivo de imagen válido.'];        				
        		}
        		         		 
        		// Si el tamaño de archivo no es el correcto, crea array de errores     		        		
        		if($logoFilename->getSize() > '600000') {
        			$errorsValidation[] = ['message' => 'El archivo excede el tamaño permitido.'];        				
        		}
        		
        		// Si el array de errores contiene elementos muestra los errores
        		if(count($errorsValidation) >= 1) {
        			return $this->render('marca/edit.html.twig', [					
						'errors' => $errorsValidation,
						'marca' => $marca,					
						'form' => $form->createView(),					
					]);										
        		}
        		else {
        			// Move the file to the directory where image profile are stored
					try {										
		                $logoFilename->move($this->getParameter('logo_marca_directory'), $newFilename);
		                $this->imageOptimizer->resize($this->getParameter('logo_marca_directory'). "/" . $newFilename); 
		            } catch (FileException $e) {
		                // ... handle exception if something happens during file upload
		                echo "No se ha podido subir la imagen";
		                echo $e->getMessage();
		            }
        		} 
                
                // updates the 'foto' property to store the image file name
                // instead of its contents
                $marca->setLogo($newFilename);
        	}    
        	
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('marca_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marca/edit.html.twig', [
            'marca' => $marca,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'marca_delete', methods: ['POST'])]
    public function delete(Request $request, Marca $marca, ValidatorInterface $validator): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para editar el perfil.');
			return $this->redirectToRoute('marca_show', ['id' => $marca->getId()]);
		}
		
        if ($this->isCsrfTokenValid('delete'.$marca->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($marca);
            $entityManager->flush();
        }

        return $this->redirectToRoute('marca_index', [], Response::HTTP_SEE_OTHER);
    }
}
