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
        <link rel="stylesheet" href="/css/bootstrap.css">
        <link rel="stylesheet" href="/css/store1.css">

    </head>
    <body>
        <div class="container-fluid">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Brand</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.navbar -->

            <div class="row-offcanvas row-offcanvas-left" >
                <div id="sidebar" class="sidebar-offcanvas" >
                    <div class="col-md-12" >
                        <h3>Sidebar (fixed)</h3>
                        @yield('sidebar');
                    </div>
                </div>
                <div id="main"> 
                    
                    <div class="col-md-12">
                        <p class="visible-xs">
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
                        </p>
                    </div>
                    
                    @yield('content')
                </div>
            </div>
        </div>
        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.js"></script>
        <script src="/js/store1.js"></script>
    </body>
</html>  