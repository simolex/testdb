<?php

namespace App\Controller;

use App\Form\VerBlockType;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HelpController extends AbstractController
{
    private $GET_OLD_BLOCKS_TABLE = '
    select id, ver_type, attr, message
    from OTHERGKN.VER_BLOCKS
    order by id';

    private $CLEAR_TABLE_NORM_BLOCK = '
        truncate table othergkn.norm_block
    ';
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
    public function set_block(EntityManagerInterface $em, LoggerInterface $logger)
    {
        //$cmd = $em->getClassMetadata($className);
        $connection = $em->getConnection();
        $connection->beginTransaction();

        try {
            //$connection->query('SET FOREIGN_KEY_CHECKS=0');
            $connection->query($this->CLEAR_TABLE_NORM_BLOCK);
            //$connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
            $em->flush();
        } catch (\Exception $e) {
            try {
                $logger->error('Can\'t truncate table OTHERGKN.NORM_BLOCK.', [ $e->getMessage() ]);
                $connection->rollback();
                throw new \Exception('Can\'t truncate table OTHERGKN.NORM_BLOCK.');
            } catch (ConnectionException $connectionException) {
                $logger->error('Can\'t rollback truncating table OTHERGKN.NORM_BLOCK.', [
                    $connectionException->getMessage()
                ]);
               throw new \Exception('Can\'t rollback truncating table OTHERGKN.NORM_BLOCK.');
            }
        }

        $stmt = $connection->prepare($this->GET_OLD_BLOCKS_TABLE);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $result = array_map (
            function ($node){
                return array_change_key_case($node, CASE_LOWER);
            },
            $result
        );
        dd($result);
        closeCursor();
    }
}
