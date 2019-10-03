<?php

namespace App\Controller;

use App\Entity\NormBlock;
use App\Form\VerBlockType;
use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
//use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function set_block(LoggerInterface $logger)
    {
        //$cmd = $em->getClassMetadata($className);
        $em = $this->getDoctrine()->getManager();
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

        $result = $connection->project(
            $this->GET_OLD_BLOCKS_TABLE,
            [],
            function ($node){
                return array_change_key_case($node, CASE_LOWER);
            }
        );

        $templateTree = [];

        $nb1 = new NormBlock();
        $nb1->setCode('1');
        $nb1->setName('Нормализация ГКН');
        $em->persist($nb1);

        $templateTree['1'] = [
            'id' => $nb1->getId(),
            'parent_id' => null,
            'childs' => [],
        ];

        $nb2 = new NormBlock();
        $nb2->setCode('2');
        $nb2->setName('Установление местоположения ОКС на ЗУ');
        $em->persist($nb2);

        $templateTree['2'] = [
            'id' => $nb2->getId(),
            'parent_id' => null,
            'childs' => [],
        ];

        $nb3 = new NormBlock();
        $nb3->setCode('3');
        $nb3->setName('Пересчет координат УСК в МСК-52');
        $em->persist($nb3);

        $templateTree['3'] = [
            'id' => $nb3->getId(),
            'parent_id' => null,
            'childs' => [],
        ];

        $em->flush();

        $isExistsNode = function () {

        };

        foreach ($result as $row) {
            $levels = $this->splitCode($row['id']);

            //TODO
        }
        //Garbidge:
        //iconv_recursive
            /*$f = function ($a) use (&$f)
                {

                    return array_map (
                        function ($b) use (&$f)
                        {

                            if(is_array($b)) {
                                 return $f($b);
                            } else {
                                return iconv('cp1251','utf-8', $b);
                            }
                        },
                        $a
                    );
                };*/
        //$stmt->closeCursor();
    }

    private function splitCode(?string $code): ?string
    {
        preg_match(
            '/^(\d{1,})(\d{2,2})(\d{2,2})(\d{2,2})$/',
            $code,
            $result
        );
        array_shift($result);
        return $result;
    }
}
