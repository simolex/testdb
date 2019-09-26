<?php

namespace App\Controller;

use App\Form\VerBlockType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HelpController extends AbstractController
{
    /**
     * @Route("/help", name="help")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(VerBlockType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {}
        return $this->render('help/index.html.twig', [
            'verBlockForm' => $form->createView()
        ]);
    }
}
