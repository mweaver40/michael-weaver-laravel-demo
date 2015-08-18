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
    <div class="row">
        <div class="col-md-6">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="{{ URL::to('/') }}/images/store/products/small/master/1_1.jpg" alt="Wetsuit">
                    </div>

                    <div class="item">
                        <img src="{{ URL::to('/') }}/images/store/products/small/master/6_3.jpg" alt="Lights">            
                    </div>
                    <div class="item">
                        <img src="{{ URL::to('/') }}/images/store/products/small/master/3_3.jpg" alt="Regulator">            
                    </div>

                    <div class="item">
                        <img src="{{ URL::to('/') }}/images/store/products/small/master/5_3.jpg" alt="Tank">        
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <p>
                Tets tets tetst testt tets tets tetst tets test tetst test tetst test test test test test test test 
            </p>
        </div>
    </div>


    <div class="row">
        <h2>
            Why buy from us?
        </h2>
        <p>
            We dive! We use the equipment we sell all over world in all types of 
            conditions. We probably know the site you are diving or have experienced 
            similar conditions so we can recomend equipment that will work for you, 
            fit you right and fit your budget. Our 10 day no questions asked return
            policy means you can buy from us with total confidence and still get great
            gear at a great price.
        </p>
    </div>
</div>
@endsection
@section('sidebar')
@include('store.catalogSideBar')
@endsection
@section('pageJavascript')
@endsection
