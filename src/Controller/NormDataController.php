<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NormDataController extends AbstractController
{
    /**
     * @Route("/norm/data", name="norm_data")
     */
    public function index()
    {
        return $this->render('norm_data/index.html.twig', [
            'controller_name' => 'NormDataController',
        ]);
    }

    public function LoadDataFile(Request $request)
    {

    }
}
