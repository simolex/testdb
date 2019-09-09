<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\DBAL\Driver\Connection;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index(Connection $conn)
    {
        $result = $conn->fetchAssoc(
            'select t.*
                from OTHERGKN.VER_BLOCK_STAGES t
                where t.id_bl_type = 201
                order by 2,3 '
        );
        return $this->json($result);
    }
}
