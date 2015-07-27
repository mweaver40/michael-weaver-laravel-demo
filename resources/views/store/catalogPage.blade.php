@extends('store.layout.masterCatalog')

<?php

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Pagination\BootstrapThreePresenter;
use phpDocumentor\Reflection\DocBlock\Type\collection;
use Illuminate\Support\Facades\URL;
use Mweaver\Util\Url as utilUrl;
use Mweaver\Pagination\BootstrapPresenter;
?>

@section('content')
<div>


    @foreach($catalogItems as $item ) 
    <div class="col-sm-6 col-md-3 browse-item ">
        <div > 
            <div class="thumbnail">
                <a href = "{{URL::route('productInfo', [$category->getAlias(),  utilUrl::cleanPath($item->name)])}}-{{$item->catalogId}}"/>
                <img width="200" height="200" src='{{URL::asset("$item->imageLocation/$item->imageName")}}'/>
                </a>
            </div>
            <div class='browse-item-name text-center' >{{$item->company}}</div>
            <div class='text-center' >{{$item->name}}</div>
            <div class='text-center'> <h4>${{$item->price}}</h4> </div>";
        </div>
    </div>
    @endforeach

    <div class="clearfix"></div>
    <div class="col-md-12 text-center"> 
        <?php
        // Kind of tacky paginator, rewrite it later
        $limit = 12;
        $paginator = new LengthAwarePaginator($catalogItems, $totalItems, $limit, null, ['path' => URL::route('catalogPage') . "/" . $category->getAlias()]);
        echo $paginator->render();
        ?>
    </div>
</div>
@endsection
@section('sidebar')
@include('store.catalogSideBar')
@endsection
@section('pageJavascript')
@endsection
