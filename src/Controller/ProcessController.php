<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProcessController extends AbstractController
{
    /**
     * @Route("/process", name="process")
     */
    public function index()
    {

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProcessController.php',
        ]);
    }
}
