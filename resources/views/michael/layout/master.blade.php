<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="stylesheet" href="{{ URL::asset('/css/bootstrap.css')}}"/>
        <link rel="stylesheet" href="{{ URL::asset('/css/welcome.css')}}"/>
        <title>Mikes Demo</title>
        <link rel="icon" type="image/png"
              href="{{ URL::asset('/images/man.png')}}" />

    </head>        
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mike-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" style="background: #dfd" href="{{URL::to('/')}}">Hire Mike</a>
                </div>
                <div class="collapse navbar-collapse" id="mike-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About Me<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{URL::route('aboutMe')}}">Who I am</a></li>
                                <li><a href="{{URL::to('/') . '/Resume6.doc'}}">Download a Resume (MS Doc)</a></li>
                                <li><a href="{{URL::route('contact')}}">Contact Info</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Sample Apps<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{URL::route('storeMain')}}">Online Store</a></li>
                                <li><a href="{{URL::route('aboutStore')}}">About the Online store</a></li>
                                <li><a href="https://github.com/mwev/laravel-demo">Git Hub Repository for Online Store</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{URL::route('aboutSite')}}">About this site</a>
                        </li>
                        <li><a href="mailto:mweavergm@gmail.com?subject=Subject&body=message%20goes%20here">Mail Me</a></li>
                            
                        
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            @yield('content')
        </div>
        <script src="{{URL::asset('/js/jquery.js')}}"></script>
        <script src="{{URL::asset('/js/bootstrap.js')}}"></script>
    </body>
</html>
