@extends('store.layout.masterCatalog')

<?php


?>

@section('content')
<div class="text-center alert alert-success ">
    Thank You For Your Order! Your confirmation id is <b>{{$orderId}}</b>
    Please record this number for your reference. If you entered a valid  
    email address then a confirmation email regarding this order will be 
    sent to that address.
</div>
@endsection
@section('sidebar')
@include('store.catalogSideBar')
@endsection