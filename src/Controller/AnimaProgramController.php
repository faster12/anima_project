<?php

namespace App\Controller;

use App\Entity\AnimaProgram;
use App\Form\AnimaProgramType;
use App\Repository\AnimaProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Psr\Log\LoggerInterface;
use Jikan\Jikan;

/**
 * @Route("/anima/program")
 */
class AnimaProgramController extends AbstractController
{
    // logger
    private $logger;
    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }

    /**
     * @Route("/anima", name="anima_program_index", methods={"GET"})
     */
    public function index(AnimaProgramRepository $animaProgramRepository,Jikan $jikan): Response
    {
        /*
            $animaprograms = $this->getDoctrine()
            ->getRepository('App\Entity\Article')
            ->findAll();
            summer spring fall winter
        */

        // list api
        $a = $jikan->Seasonal(2020);
        
        // set array
        $score = [];$source = [];$list = [];
        foreach($a->anime as $k => $anime){
            $score[] = $anime->getScore();
        }

        // ordena array
        arsort($score);

        // cria list
        foreach($score as $k => $v){
            
            // descricao
            $desc = $a->anime[$k]->getSynopsis();

            // listagem
            $list[] = [
                'title' => $a->anime[$k]->getTitle(),
                'image' => $a->anime[$k]->getImageURL(),
                'description' => $desc,
                'description_low' => substr($desc,0,100),
                'score' => $v
            ];

            if($k==20){
                break;
            }
        }

        // set log
        $this->logger->info('listed');

        return $this->render('anima_program/index.html.twig', [
            'anima_programs' => $animaProgramRepository->findAll(),
            'animas' => $list
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

        /*
            $article = $form->getData();
        */

        if ($form->isSubmitted()) {
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

        $em = $this->getDoctrine()->getManager();
        $program = $em->getRepository('App\Entity\AnimaProgram')->find($animaProgram->getId());

        if (!$program) {
            throw $this->createNotFoundException(
                'ops, nao encontrado: '
            );
        }

        $em->remove($program/* $animaProgram */);
        $em->flush();

        return $this->redirectToRoute('anima_program_index');
    }
}
