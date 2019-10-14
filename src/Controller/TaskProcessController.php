<?php

namespace App\Controller;

use App\Repository\NormProcessRepository;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TaskProcessController extends AbstractController
{

    /**
     * @Route("/task_process", name="task_process")
     */
    public function index(NormProcessRepository $repository)
    {
        $processes = $repository->findAll();


        return $this->json($processes);
    }


    /**
     * @Route("/task_process/new", name="task_process_new")
     */
    public function new(NormProcess $process)
    {
        $Tasks = $repository->findAll();
        return $this->redirectToRoute('task_process')

        return $this->json($Tasks);
    }


}
