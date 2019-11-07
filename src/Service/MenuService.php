<?php

namespace App\Service;

use App\Repository\MenuRepository;
//use Symfony\Component\DependencyInjection\Container;

class MenuService
{
    //private $doctrine;
    //private $container;
    private $repository;

    public function __construct(MenuRepository $repository)
    {
        //$this->container = $container;
        //$this->doctrine = $this->container->get('doctrine');
        $this->repository = $repository;//$this->doctrine->getRepository('App:Menu');
    }

    public function getMainMenu()
    {
        return $this->repository->getMainMenu();
    }
}