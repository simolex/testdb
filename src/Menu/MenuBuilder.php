<?php

namespace App\Menu;


use App\Repository\MenuRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
	private $factory;
	private $repository;

	public function __construct(FactoryInterface $factory, MenuRepository $repository)
	{
		$this->factory = $factory;
		$this->repository = $repository;
	}

	public function mainMenu(array $options)
    {
        $menuItems = $this->repository->getMainMenu();
        $menu = $this->factory->createItem('root');

        //$this->setCurrentItem($menu);

        $menu->setChildrenAttribute('class', 'main-navi_list');
        $menu->setChildrenAttribute('id', 'yw0');
        $menu->setExtra('currentElement', 'active');

        foreach($menuItems as $item) {
        	if($item->getParent() !== null){
        		$parent = $this->repository->find($item->getParent());
        		//dd($menu, $parent);
        		$parentItem =  $menu[$parent->getTitle()];
        		$parentItem
        			//->setAttribute("class", $parentItem->getAttribute('class')." dropdown")
        			->setChildrenAttribute('class', 'main-navi__drop')
        			->addChild($item->getTitle(), array('uri' => $item->getRoute()))
        			->setAttribute("class", "main-navi__drop_item")
        			->setLinkAttribute('class', 'main-navi__drop_link')
        		;


        	} else {
	        	$itemTitle = $item->getTitle();
	            $menu->addChild($itemTitle, array('uri' => $item->getRoute()));
	            $menu[$itemTitle]
	            	->setAttribute('class', 'nav-item main-navi_item')
	            	->setLinkAttribute('class', 'nav-link main-navi_link')
	            ;
	        }

        }

        return $menu;
    }

    protected function setCurrentItem(ItemInterface $menu, Request $request)
    {
        $menu->setCurrentUri($request->getPathInfo());
    }
}