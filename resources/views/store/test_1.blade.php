@extends('store.layout.masterCatalog')

<?php

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use phpDocumentor\Reflection\DocBlock\Type\collection;
use Illuminate\Support\Facades\URL;
?>

@section('content')
<div>
    <?php
    //var_dump($catalogItems);
    foreach ($catalogItems as $item) {
        print('<div class="col-sm-6 col-md-3 browse-item">');
        echo "<div>";
        print '<div class="thumbnail">';
        echo "<img src='" . URL::asset("$item->imageLocation/$item->imageName") . "'>";
        echo "</div>";
        print('<div class=browse-item-name >' . $item->company . "</div>");
        echo '<div class="product-name" > ' . $item->name . "</div>";
        echo '<div> <h4>$' . $item->price . "</h4> </div>";
        //echo '<p><a class="btn btn-primary btn-sm" href="#" role="button">Add to cart</a></p>';
        print(' </div>');
        echo('</div>');
    }
    ?>
    <div class="clearfix"></div>
    <div class="col-md-4 col-sm-6"> 
    </div>
    <div class="col-md-4 col-sm-6">
        <?php
        $paginator = new LengthAwarePaginator($catalogItems, 100, $limit, null, ['path' => URL::route('testDoit')]);
        //$bsPaginator = new BootstapThreePresenter();
        echo $paginator->render();
        ?>
    </div>
    <div class="col-md-4 col-sm-6"> 
    </div>
</div>
@endsection
