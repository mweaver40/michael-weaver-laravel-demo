@extends('store.layout.masterCatalog')

<?php
?>
@section('content')

<div id="addToCartOK"  class="col-md-12 storeMsg statusOK ">
    <div class="vcenter">
    <span class="glyphicon glyphicon-ok"></span> <span> {{$catalog->product->name}} added to cart</span>
    </div>
          <div class='vcenter' style='height:100%;width:0px'></div>
</div>

<div id="addToCartFail"  class="col-md-12 storeMsg statusFail ">
    <div class="vcenter">
    <span class="glyphicon glyphicon-remove"></span> <span>Unable to add {{$catalog->product->name}} to cart, try again later" </span>
    </div>
          <div class='vcenter' style='height:100%;width:0px'></div>
</div>


<div>
    <div class="col-md-6">
        <div class="img-responsive">
            <img class='image-resize-responsive' src='{{$images[0]->getUrl()}}'/> 
        </div>
    </div>
    <div class="col-md-6">
        <h2>{{$catalog->name}}</h2>
        <div class="col-md-12">
            {{$catalog->description->description}}
        </div>
        <div class="col-md-12">
            <h2>${{$price->price}}</h2>
        </div>
        <div id="addToCart" >
            <form class="form-inline" method="post" action="{{URL::route('addToCart')}}">
                <div class="col-md-4 col-xs-6">
                    <label for="quantity">Qty:</label>
                    <input type="text"  name="quantity" style="width: 15%"  id="quantity" value="1">

                </div>

                <div class="col-md-8 col-xs-6">
                    <input type="hidden" value="{{$catalog->product->id}}" name="productId"/>
                    <input type="hidden" name="_token" id="csrf-token" value="{!!Session::token()!!}"/>
                    <button class="btn btn-success btn-large"  type="submit" >
                        <i class="icon-white icon-shopping-cart"></i> 
                        Add to Cart</button>

<!--
                    <button class="controls form-inline btn btn-success btn-large">
                        <i class="icon-white icon-shopping-cart"></i> 
                        Add to Cart</button>
                </div>   
-->
            </form>
        </div>

    </div>
</div>
</div>
@endsection
@section('sidebar')
@include('store.catalogSideBar')
@endsection