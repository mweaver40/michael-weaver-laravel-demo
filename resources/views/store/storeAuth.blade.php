@extends('store.layout.masterCatalog')
<?php

use Mweaver\Store\Util\FormUtil;

?>
/* 
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/
@section('content')

<form class="form-horizontal" role='form' id='checkout-auth-form' action="{{URL::route('login')}}" method="post">



    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">

            <div class="radio"><label><input type="radio" id="login"                                                   
                                             {{ FormUtil::oldRadio('optCheckout', 'login', true) }} 
                                             value="login" name="optCheckout">Login</label>
            </div>
        </div>

        <div class="col-sm-offset-4 col-sm-8">
            <div class="radio"><label ><input type="radio" data-xurl="{{URL::route('register')}}" id="register" 
                                              {{ FormUtil::oldRadio('optCheckout', 'register') }} 
                                              name="optCheckout" value="register" >Register</label></div>
        </div>
        <div class="col-sm-offset-4 col-sm-8">
            <div class="radio"><label ><input type="radio" {{ FormUtil::oldRadio('optCheckout', 'guest') }}
                                              id="guest" name="optCheckout" value="guest">Login as guest</label></div>  
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Failed </strong> Please correct the following.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div id="checkout-auth">
        <div class="form-group register-account" hidden>
            <label class="col-sm-4 control-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control required" name="firstName" value="{{ old('firstName') }}" disabled>
            </div>    
        </div>

        <div class="form-group register-account" hidden>
            <label class="col-sm-4 control-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control required" name="lastName" value="{{ old('lastName') }}" disabled >
            </div>    
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">E-Mail Address</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" id="authEmail" value="{{ old('email') }}" name="email" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Password</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="authPassword" name="password">
            </div>
        </div>

        <div class="form-group register-account" hidden>
            <label class="col-sm-4 control-label">Confirm Password</label>
            <div class="col-sm-6">
                <input type="password" class="form-control required" 
                       name="password_confirmation" disabled>
            </div>    
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <button class="btn btn-large btn-success" id="chkoutCont" 
                    type="submit" name="chkoutCont" type="button">Continue</button>
        </div>
    </div>

</form>
<script>
    function doChkoutAuth2()
    {
        alert("XXXXX");
    }
</script>

@endsection

@endsection
@section('sidebar')
@include('store.catalogSideBar')
@endsection
