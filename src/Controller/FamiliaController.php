<?php

namespace App\Controller;

use App\Entity\Familia;
use App\Form\FamiliaType;
use App\Repository\FamiliaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/familia')]
class FamiliaController extends AbstractController
{
    /**
     * @var \Doctrine\Persistence\ManagerRegistry
     */
    private $managerRegistry;
    public function __construct(\Doctrine\Persistence\ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
    #[Route('/', name: 'familia_index', methods: ['GET'])]
    public function index(FamiliaRepository $familiaRepository): Response
    {
        return $this->render('familia/index.html.twig', [
            'familias' => $familiaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'familia_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $familium = new Familia();
        $form = $this->createForm(FamiliaType::class, $familium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($familium);
            $entityManager->flush();

            return $this->redirectToRoute('familia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('familia/new.html.twig', [
            'familium' => $familium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'familia_show', methods: ['GET'])]
    public function show(Familia $familium): Response
    {
        return $this->render('familia/show.html.twig', [
            'familium' => $familium,
        ]);
    }

    #[Route('/{id}/edit', name: 'familia_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Familia $familium): Response
    {
        $form = $this->createForm(FamiliaType::class, $familium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->managerRegistry->getManager()->flush();

            return $this->redirectToRoute('familia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('familia/edit.html.twig', [
            'familium' => $familium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'familia_delete', methods: ['POST'])]
    public function delete(Request $request, Familia $familium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$familium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->remove($familium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('familia_index', [], Response::HTTP_SEE_OTHER);
    }
}
