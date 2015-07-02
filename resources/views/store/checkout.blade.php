@extends('store.layout.masterCatalog')

<?php
?>


@section('content')







<div id=checkout-panel-group class="panel-group">


    <div id="billing-panel" class="panel panel-default">

        <!-- <div class="panel-heading input-lg"><b>Billing Address</b></div> -->
        <div class="panel-heading">
            <div>
                <h4 class="panel-title">
                    <a data-toggle="collapse"  data-parent="#checkout-panel-group"  href="#billing-panel-body">Billing Address</a>
                </h4>
            </div>
        </div>
        <div id="billing-panel-body" class="panel-body collapse in ">
            <form role='form' id='billing-address-form' action="#" method="get">
                <div class="form-group col-xs-6 required input-group-sm">
                    <label class="control-label input-sm">First Name</label>
                    <div>
                        <input  class="form-control required input-sm" name="firstName" value="{{ old('firstName') }}">
                    </div>    
                </div>

                <div class="form-group col-xs-6 required input-group-sm">
                    <label class="control-label input-sm">Last Name</label>
                    <div>
                        <input  type="text" class="form-control required input-sm" name="lastName" value="{{ old('lastName') }}">
                    </div>    
                </div>

                <div class="form-group col-xs-6 input-group-sm">
                    <label class="control-label input-sm">Company</label>
                    <div>
                        <input type="text" class="form-control  input-sm" name="company" value="{{ old('company') }}">
                    </div>    
                </div>

                <div class="form-group required col-xs-6 input-group-sm">
                    <label class="control-label input-sm">Telephone</label>
                    <div>
                        <input required type="text" class="form-control required-integer input-sm" name="telephone" value="{{ old('telephone') }}">
                    </div>    
                </div>


                <div class="form-group required col-xs-12 input-group-sm">
                    <label class="control-label i requirednput-sm">Address</label>
                    <div>
                        <input type="text" class="form-control required input-sm" name="address1" value="{{ old('address1') }}">
                    </div>    
                </div>

                <div class="form-group col-xs-12 input-group-sm">
                    <div>
                        <input type="text" class="form-control  input-sm" name="address2" value="{{ old('address2') }}">
                    </div>    
                </div>

                <div class="form-group required col-xs-6 input-group-sm">
                    <label class="control-label input-sm">City</label>
                    <div>
                        <input type="text" class="form-control required input-sm" name="City" value="{{ old('City') }}">
                    </div>    
                </div>

                <div class="form-group required col-xs-6 input-group-sm">
                    <label class="control-label input-sm">State</label>
                    <div>
                        <input type="text" class="form-control required input-sm" name="State" value="{{ old('State') }}">
                    </div>    
                </div>

                <div class="form-group required col-xs-6 input-group-sm">
                    <label class="control-label input-sm">Zip/Postal Code</label>
                    <div>
                        <input type="text" class="form-control input-sm required-integer" name="zipcode" value="{{ old('zipcode') }}">
                    </div>    
                </div>

                <div class="form-group required col-xs-6 input-group-sm">
                    <label class="control-label input-sm">Country</label>
                    <div>
                        <input type="text" class="form-control required input-sm" name="country" value="{{ old('country') }}">
                    </div>    
                </div>

                <div class="col-xs-12">
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                </div>

            </form>
        </div>
    </div>

    <div id="shipping-panel" class="panel panel-default">
        <div class="panel-heading">
            <div>
                <h4 class="panel-title">
                    <a data-toggle="collapse"  disabled data-parent="#checkout-panel-group" href="#shipping-panel-body">Shipping Address</a>
                </h4>
            </div>
        </div>
        <div id="shipping-panel-body" class="panel-body collapse">
            <form role='form' id='shipping-address-form' name="buttonUseBilling" action="#" method="get">    
                <div class="col-xs-12">
                    <button  class="btn btn-primary btn-sm" value="useBilling">Use Billing Address</button>
                </div>
                @include('store.addressFields')
            </form>
        </div>
    </div>
    <div id="payment-panel" class="panel panel-default">
        <div class="panel-heading">
            <div>
                <h4 class="panel-title">
                    <a data-toggle="collapse" disabled data-parent="#checkout-panel-group" href="#payment-panel-body">Payment Method</a>
                </h4>
            </div>
        </div>
        <!-- The following is from Richard Cotrina om stack overflow -->
        <div id="payment-panel-body" class="panel-body collapse">
            <form role='form' id='payment-form' action="#" method="get">          
                <div class="cc-selector">
                    <div class="col-xs-6, col-sm-3 ">
                        <input type="radio" id="visa" name="cardType" value="visa" >
                        <label class="drinkcard-cc visa  control-label" for="visa"></label>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <input id="mastercard" type="radio" name="cardType" value="mastercard">
                        <label class="drinkcard-cc mastercard  control-label" for="mastercard"></label>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <input id="amex" type="radio" name="cardType" value="amex">
                        <label class="drinkcard-cc amex  control-label" for="amex"></label>
                    </div>
                </div>

                <div class="clearfix"></div>   
                <div class="row">
                    <div class="form-group required col-xs-12 col-sm-6 input-group-sm">

                        <label class="control-label input-sm" for="creadtCardNumber">Card number</label>
                        <div>
                            <input id="creditCardNumber" type="text" class="form-control required input-sm" name="creditCardNumber">
                        </div> 
                    </div>
                </div>
                <div class="row"> 
                    <div class="form-group required col-xs-12 col-sm-6" >
                        <label class="control-label  input-sm" for="expireDate">Expiration Date</label> 
                        <div id="expireDate">
                        <div class="col-xs-3">
                            <select class="form-control col-sm-2 input-group-sm"  name="expiry-month" id="expiry-month">
                                <option>Month</option>
                                <option value="01">Jan (01)</option>
                                <option value="02">Feb (02)</option>
                                <option value="03">Mar (03)</option>
                                <option value="04">Apr (04)</option>
                                <option value="05">May (05)</option>
                                <option value="06">June (06)</option>
                                <option value="07">July (07)</option>
                                <option value="08">Aug (08)</option>
                                <option value="09">Sep (09)</option>
                                <option value="10">Oct (10)</option>
                                <option value="11">Nov (11)</option>
                                <option value="12">Dec (12)</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <select class="form-control input-group-sm" name="expiry-year">
                                <option value="15">2015</option>
                                <option value="16">2016</option>
                                <option value="17">2017</option>
                                <option value="18">2018</option>
                                <option value="19">2019</option>
                                <option value="20">2020</option>
                                <option value="21">2021</option>
                                <option value="22">2022</option>
                                <option value="23">2023</option>
                                <option value="23">2024</option>
                                <option value="23">2025</option>
                            </select>
                        </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>

        <!--
        <div class="cc-selector col-sm-12">
                            <div class="col-sm-1">
                                <input type="radio" id="visa" name="cardType" value="visa" >
                                <label class="drinkcard-cc visa  control-label" for="visa"></label>
                            </div>
                            <div class="col-sm-1">
                                <input id="mastercard" type="radio" name="cardType" value="mastercard">
                                <label class="drinkcard-cc mastercard  control-label" for="mastercard"></label>
                            </div>
                            <div class="col-sm-1">
                                <input id="amex" type="radio" name="cardType" value="amex">
                                <label class="drinkcard-cc amex  control-label" for="amex"></label>
                            </div>
                        </div>
        -->
        <div id="order-config-panel" class="panel panel-default">
            <div class="panel-heading">
                <div>
                    <h4 class="panel-title">
                        <a data-toggle="collapse" disabled data-parent="#checkout-panel-group" href="#order-confirm-panel-body">Confirm Order</a>
                    </h4>
                </div>
            </div>

            <div id="order-confirm-panel-body" class="panel-body collapse">
                <form role='form' id='order-confirm-form' action="#" method="get">          

                </form>
            </div>
        </div>
    </div>
    @endsection
    @section('sidebar')
    @include('store.catalogSideBar')
    @endsection