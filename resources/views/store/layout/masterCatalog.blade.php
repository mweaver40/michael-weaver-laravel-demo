<?php
use Illuminate\Support\Facades\URL;
?>
<html>
    <head> 

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Test Page</title>

        <!-- Bootstrap core CSS -->
        <!-- <link href="css/bootstrap.css" rel="stylesheet"> -->
        
        <link rel="stylesheet" href="{{ URL::asset('/css/bootstrap.css')}}"/>
        <link rel="stylesheet" href="{{ URL::asset('/css/store1.css')}}"/>

        <!--
        <link rel="stylesheet" href="/css/bootstrap.css">
        <link rel="stylesheet" href="/css/store1.css">
        -->

    </head>
    <body>



        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar2,#navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="background: #dfd" href="#"><span style="margin-top: -50%"> Hire</span> Mike</a>

            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul> 

                <!--shoppingCartCnt-->
            </div><!--/.nav-collapse -->

        </div><!--/.navbar -->

        <div class="container-fluid">

            <div class="row-offcanvas row-offcanvas-left" >
                <div id="sidebar" class="sidebar-offcanvas" >
                    <div class="col-md-12" >
                        <h3>Sidebar (fixed)</h3>
                        @yield('sidebar');
                    </div>
                </div>
                <div id="main"> 
                    <div class="navbar navbar-default navbar-static-top">

                        <div id="navbar2" class="navbar-default">
                           

                                <div class="pull-right">
                                    <button class="btn btn-default navbar-btn">
                                        <span class="glyphicon glyphicon-shopping-cart" ></span> <br/>Login
                                    </button>
                                    <button class="btn btn-default navbar-btn">
                                        <span class="glyphicon glyphicon-shopping-cart" ></span> <br/>Account
                                    </button>
                                    <button class="btn btn-default navbar-btn">
                                        <span class="glyphicon glyphicon-shopping-cart" ></span> <br/>Cart
                                        <span id="shop-cart-button-cnt" class="badge badge-success badge-xs">
                                            10</span>
                                    </button>
                                </div>
                             <form class="navbar-form" role="search">
                                <div class="input-group">
                                    <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                             </form>
                        </div><!--/.nav-collapse -->
                    </div>
                    <div class="col-md-12">
                        <p class="visible-xs">
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
                        </p>
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>
        <script src="{{URL::asset('/js/jquery.js')}}"></script>
        <script src="{{URL::asset('/js/bootstrap.js')}}"></script>
        <script src="{{URL::asset('/js/store1.js')}}"></script>
    </body>
</html>  