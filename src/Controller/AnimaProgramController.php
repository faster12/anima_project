<?php

namespace App\Controller;

use App\Entity\AnimaProgram;
use App\Form\AnimaProgramType;
use App\Repository\AnimaProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/anima/program")
 */
class AnimaProgramController extends AbstractController
{
    /**
     * @Route("/anima", name="anima_program_index", methods={"GET"})
     */
    public function index(AnimaProgramRepository $animaProgramRepository): Response
    {
        return $this->render('anima_program/index.html.twig', [
            'anima_programs' => $animaProgramRepository->findAll(),
        ]);
    }

    /**
     * @Route("/anima/new", name="anima_program_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $animaProgram = new AnimaProgram();
        $form = $this->createForm(AnimaProgramType::class, $animaProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($animaProgram);
            $entityManager->flush();

            return $this->redirectToRoute('anima_program_index');
        }

        return $this->render('anima_program/new.html.twig', [
            'anima_program' => $animaProgram,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/anima/{id}", name="anima_program_show", methods={"GET"})
     */
    public function show(AnimaProgram $animaProgram): Response
    {
        return $this->render('anima_program/show.html.twig', [
            'anima_program' => $animaProgram,
        ]);
    }

    /**
     * @Route("/anima/{id}/edit", name="anima_program_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AnimaProgram $animaProgram): Response
    {
        $form = $this->createForm(AnimaProgramType::class, $animaProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('anima_program_index');
        }

        return $this->render('anima_program/edit.html.twig', [
            'anima_program' => $animaProgram,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/anima/{id}", name="anima_program_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AnimaProgram $animaProgram): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animaProgram->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($animaProgram);
            $entityManager->flush();
        }

        return $this->redirectToRoute('anima_program_index');
    }
}
