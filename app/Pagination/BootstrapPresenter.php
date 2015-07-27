<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Mweaver\Pagination;
use Illuminate\Pagination\BootstrapThreePresenter;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Pagination\UrlWindow;

/**
 * Description of BootstrapPresenter
 *
 * @author MIchael
 */
class BootstrapPresenter extends  BootstrapThreePresenter{
    //put your code here
    /**
     * 
     * @param PaginatorContract $paginator
     * @param type $onEachSide Number of URLS on each side of current page to 
     * display in slider. Some additional URLS thrown in by UrlWindow.
     * @param UrlWindow $window
     */
    public function __construct(PaginatorContract $paginator, $onEachSide = 3, UrlWindow $window = null)
	{
		$this->paginator = $paginator;
		$this->window = is_null($window) ? UrlWindow::make($paginator, $onEachSide) : $window->get();
	}
}
