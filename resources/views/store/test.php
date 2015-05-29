<?php
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use phpDocumentor\Reflection\DocBlock\Type\collection;
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
       <link rel="stylesheet" href="/css/bootstrap.css">
        <script src="/js/bootstrap.js"></script>
        <script src="/js/jquery.js"></script>
      
        
    </head>
    <body>
         <div class="container-fluid"> 
            <h1>name = <?php echo $name ?></h1>
            <div class=pagination-sm>
            <?php
            
            $items = ["1","2","3","4","5","6","7","8","9","10"];
            //$items = new Collection(["1","2","3","4","5","6","7","8","9","10"]);
             $paginator = new LengthAwarePaginator($items, 100, 5);
            //$bsPaginator = new BootstapThreePresenter();
            echo $paginator->render();
            
            ?>
            </div>
        </div>
    </body>
</html>
