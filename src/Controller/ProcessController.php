<?php

namespace App\Controller;

use App\Entity\NormProcess;
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
        $processesQuery = $repository->findAll();


        //dd( $processes);


        return $this->json($processesQuery);
    }



}
