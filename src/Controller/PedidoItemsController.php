<?php

namespace App\Controller;

use App\Entity\PedidoItems;
use App\Form\Pedido\PedidoItemsType;
use App\Repository\PedidoItemsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PedidoCallCenter;

#[Route('/pedido/items')]
class PedidoItemsController extends AbstractController
{
    /**
     * @var \Doctrine\Persistence\ManagerRegistry
     */
    private $managerRegistry;
    public function __construct(\Doctrine\Persistence\ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
    #[Route('/', name: 'pedido_items_index', methods: ['GET'])]
    public function index(PedidoItemsRepository $pedidoItemsRepository): Response
    {
        return $this->render('pedido_items/index.html.twig', [
            'pedido_items' => $pedidoItemsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'pedido_items_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
    	//$pedidoCallCenter = new PedidoCallCenter();
        $pedidoItem = new PedidoItems();
        $form = $this->createForm(PedidoItemsType::class, $pedidoItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	//$pedidoItem->setPedidoCallCenter($pedidoCallCenter);
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($pedidoItem);
            $entityManager->persist($pedidoCallCenter);
            $entityManager->flush();

            return $this->redirectToRoute('pedido_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pedido_items/new.html.twig', [
            'pedido_item' => $pedidoItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'pedido_items_show', methods: ['GET'])]
    public function show(PedidoItems $pedidoItem): Response
    {
        return $this->render('pedido_items/show.html.twig', [
            'pedido_item' => $pedidoItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'pedido_items_edit', methods: ['GET','POST'])]
    public function edit(Request $request, PedidoItems $pedidoItem): Response
    {
        $form = $this->createForm(PedidoItemsType::class, $pedidoItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->managerRegistry->getManager()->flush();

            return $this->redirectToRoute('pedido_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pedido_items/edit.html.twig', [
            'pedido_item' => $pedidoItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'pedido_items_delete', methods: ['POST'])]
    public function delete(Request $request, PedidoItems $pedidoItem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pedidoItem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->remove($pedidoItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pedido_items_index', [], Response::HTTP_SEE_OTHER);
    }
}
