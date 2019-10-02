<?php

namespace App\Controller;

use App\Form\VerBlockType;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HelpController extends AbstractController
{
    private $GET_OLD_BLOCKS_TABLE = '
    select id, ver_type, attr, message
    from OTHERGKN.VER_BLOCKS
    order by id';
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

    /**
     * @Route("/set_block", name="block")
     */
    public function set_block(Connection $connection)
    {
        $stmt = $connection->prepare($this->GET_OLD_BLOCKS_TABLE);
        $stmt->execute();
        var_dump($stmt->fetchAll());die;
    }
}
