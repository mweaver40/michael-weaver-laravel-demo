@extends('store.layout.masterCatalog')

<?php
use Mweaver\Store\Product\Image;
?>
@section('content')

<div id="getCart" class="container-fluid">

    @if(isset($cart)&& !$cart->items->isEmpty())
    <form id="cart-form" name="cart-form" class="form" method="post" action="{{URL::route('updateCart')}}">
        <div class="row">
            <div class="col-md-3 col-lg-3 hidden-xs hidden-sm" ></div>

            <div class="col-md-3 col-lg-3 col-sm-5 col-xs-5"><h4>Product</h4></div>

            <div class="col-md-2 col-sm-2 col-lg-2 hidden-xs" ><h4>Quantity</h4></div>
            <div class="hidden-lg hidden-md hidden-sm col-xs-2"><h4>#</h4></div>

            <div class="col-md-4 col-sm-5 col-lg-4 col-xs-5"><h4>Price</h4></div>
        </div>

        <?php $cnt = 1; ?>
        @foreach($cart->items as $item ) 
        <div class="row-divider"> </div>
        <div class="row">
            <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                <img width="40" height="40" src='{{URL::asset(Image::getMainThumbURL($item->catalog->product_id))}}'/>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-5 col-xs-5">{{$item->catalog->name}}</div>
            <div class="col-lg-2 col-sm-2 col-xs-2 col-md-2">
                <input type="text"  class="required-integer" name="quantity-{{$cnt}}"  style="width: 2em" value="{{$item->quantity}}">
                <input type="text"  name="item-id-{{$cnt}}" value="{{$item->id}}" style="visibility: hidden"/>
                <input type="hidden" name="_token" id="csrf-token" value="{!!Session::token()!!}"/>
            </div>
            <?php $price = $item->catalog->product->getEffectivePrice()->price; ?>

            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">${{$price}}</div>


            <div class="col-lg-2 col-sm-2 col-xs-2 col-md-2">
                <a href="{{URL::route('removeFromCart',[$item->id])}}"><span class="glyphicon glyphicon-trash"></span>
                </a>
            </div> 
            <!--
            <div style="hidden-xs hidden-sm hidden-md hidden-lg">
            <input type="text"  name="catalog-id" value="$item-id" style="visibility: hidden"/> -->
        </div>
        <?php $cnt++; ?>
        @endforeach       
        <div class="row-divider"> </div>
        <div class="row">
            <div class="text-center">
                <span><h3>Total ${{$total}}</h3></span>
            </div>
        </div>
        <div class="row">
            <div class="text-center">
                <button class="btn btn-large btn-primary" name="update" type="submit">Update Cart</button>
                <a class="btn btn-large btn-success" href='{{URL::route("checkout")}}' >Checkout</a>
            </div>
        </div>
        @else
        <div>
            <p><h3>Cart is empty</h3></p>
        </div>
        @endif
</div>




@endsection
@section('sidebar')
@include('store.catalogSideBar')
@endsection

@section('pageJavascript')
<script>
$('#checkoutButton').click(function(){
  $('form[name=cart-form]').attr('action','{{URL::route("checkout")}}');
  $('form[name=cart-form]').submit();
});
</script>
@endsection