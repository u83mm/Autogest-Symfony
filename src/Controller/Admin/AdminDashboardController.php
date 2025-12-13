<?php

namespace App\Controller\Admin;

use App\Entity\Departamentos;
use App\Entity\Familia;
use App\Entity\TipoEstado;
use App\Entity\Stock;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminDashboardController extends AbstractDashboardController
{
	private $security;
    /**
     * @var \EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator
    */
    private $adminUrlGenerator;

	public function __construct(Security $security, \EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator $adminUrlGenerator)
	{       
	    $this->security = $security;
        $this->adminUrlGenerator = $adminUrlGenerator;
	}	
	   
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para acceder.');
			return $this->redirectToRoute('main_menu');
		}

        // redirect to some CRUD controller
        $this->adminUrlGenerator;
        //return $this->redirect($routeBuilder->setController(DepartamentosCrudController::class)->generateUrl());
        return $this->render('dashboard/base.html.twig', [
        	'my_own_data' => '',
        ]);

        // you can also redirect to different pages depending on the current user
        /*if ('jane' === $this->getUser()->getUsername()) {
            return $this->redirect('...');
        }*/
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img style="width: 45%;" src="favicon.ico"> AutoDevelop');            
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if(!$user instanceof User) {
            throw new \Exception('Usuario equivocado');
        }

        return parent::configureUserMenu($user)
            ->setAvatarUrl('uploads/image_profile/' . $user->getFoto())
            ->setMenuItems([
                MenuItem::linkToUrl('Mi perfil', 'fas fa-user', $this->generateUrl('user_show', [ 'id' => $user->getId() ]))
            ]);
    }

    public function configureMenuItems(): iterable
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para acceder.');
			return $this->generateUrl('main_menu');
		}

        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');       
        yield MenuItem::linkToCrud('Departamento', 'fas fa-desktop', Departamentos::class);               
        yield MenuItem::linkToCrud('Familia', 'fas fa-list', Familia::class);
        yield MenuItem::linkToCrud('Estado', 'fas fa-list', TipoEstado::class);
        yield MenuItem::linkToCrud('Stock', 'fas fa-list', Stock::class);
        yield MenuItem::linkToUrl('Volver', 'fa fa-angle-double-left', $this->generateUrl('main_menu'));      
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
