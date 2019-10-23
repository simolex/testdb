<?php

namespace App\Controller;

use App\Entity\NormBlock;
use App\Entity\NormProcess;
use App\Form\NormBlockType;
use App\Repository\NormBlockRepository;
use App\Repository\NormProcessRepository;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProcessController extends AbstractController
{

    /**
     * @Route("/process", name="process")
     */
    public function index(NormProcessRepository $repository)
    {
        $processesQuery = $repository->findAll();

        foreach($processesQuery as $process) {
            $processes[$process->getId()] = $process;
        }
        //dd( $processes);

        return $this->render('process/list.html.twig', [
            'processes' => $processes,
        ]);
        //return $this->json($processes);
    }


    /**
     * @Route("/process/new", name="process_new")
     */
    public function new(NormProcess $process)
    {
        $Tasks = $repository->findAll();
        return $this->redirectToRoute('task_process');

        return $this->json($Tasks);
    }


    /**
     * @Route("/process/test", name="process_test")
     */
    public function test(NormBlockRepository $repository)
    {
        // $node1 = $repository->findOneBy(['code' => 3, 'parent' => null]);
        // $processesQuery = $repository->childrenHierarchy($node1);


        // dd( $processesQuery);
        //
         $block = new NormBlock();

        $form = $this->createForm(NormBlockType::class, $block);

        return $this->render('process/test.html.twig', [
            'form' => $form->createView(),
        ]);
        //return $this->json($processesQuery);
    }



}
