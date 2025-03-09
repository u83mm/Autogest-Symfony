<?php

namespace App\Controller;

use App\Entity\TipoEstado;
use App\Form\TipoEstadoType;
use App\Repository\TipoEstadoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tipo/estado')]
class TipoEstadoController extends AbstractController
{
    /**
     * @var \Doctrine\Persistence\ManagerRegistry
     */
    private $managerRegistry;
    public function __construct(\Doctrine\Persistence\ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
    #[Route('/', name: 'tipo_estado_index', methods: ['GET'])]
    public function index(TipoEstadoRepository $tipoEstadoRepository): Response
    {
        return $this->render('tipo_estado/index.html.twig', [
            'tipo_estados' => $tipoEstadoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'tipo_estado_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $tipoEstado = new TipoEstado();
        $form = $this->createForm(TipoEstadoType::class, $tipoEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($tipoEstado);
            $entityManager->flush();

            return $this->redirectToRoute('tipo_estado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_estado/new.html.twig', [
            'tipo_estado' => $tipoEstado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tipo_estado_show', methods: ['GET'])]
    public function show(TipoEstado $tipoEstado): Response
    {
        return $this->render('tipo_estado/show.html.twig', [
            'tipo_estado' => $tipoEstado,
        ]);
    }

    #[Route('/{id}/edit', name: 'tipo_estado_edit', methods: ['GET','POST'])]
    public function edit(Request $request, TipoEstado $tipoEstado): Response
    {
        $form = $this->createForm(TipoEstadoType::class, $tipoEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->managerRegistry->getManager()->flush();

            return $this->redirectToRoute('tipo_estado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_estado/edit.html.twig', [
            'tipo_estado' => $tipoEstado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tipo_estado_delete', methods: ['POST'])]
    public function delete(Request $request, TipoEstado $tipoEstado): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoEstado->getId(), $request->request->get('_token'))) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->remove($tipoEstado);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipo_estado_index', [], Response::HTTP_SEE_OTHER);
    }
}
