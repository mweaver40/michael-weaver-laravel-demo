


<input type="hidden" name="_token" value="{!!Session::token()!!}"/>


<div class="form-group col-xs-6 required input-group-sm">
    <label class="control-label input-sm">First Name</label>
    <div>
        <input  class="form-control required input-sm" name="firstName" value="{{ emptyStr($address->first_name) }}">
    </div>    
</div>

<div class="form-group col-xs-6 required input-group-sm">
    <label class="control-label input-sm">Last Name</label>
    <div>
        <input   class="form-control required input-sm" name="lastName" value="{{ emptyStr($address->last_name) }}">
    </div>    
</div>

<div class="form-group col-xs-6 input-group-sm">
    <label class="control-label input-sm">Company</label>
    <div>
        <input type="text" class="form-control  input-sm" name="company" value="{{ emptyStr($address->company) }}">
    </div>    
</div>

<div class="form-group required col-xs-6 input-group-sm">
    <label class="control-label input-sm">Telephone</label>
    <div>
        <input required type="text" class="form-control required-integer input-sm" name="telephone" value="{{ emptyStr($address->telephone) }}">
    </div>    
</div>


<div class="form-group required col-xs-12 input-group-sm">
    <label class="control-label i requirednput-sm">Address</label>
    <div>
        <input type="text" class="form-control required input-sm" name="line1" value="{{ emptyStr($address->line_1) }}">
    </div>    
</div>

<div class="form-group col-xs-12 input-group-sm">
    <div>
        <input type="text" class="form-control  input-sm" name="line2" value="{{ emptyStr($address->line_2)}}">
    </div>    
</div>

<div class="form-group required col-xs-6 input-group-sm">
    <label class="control-label input-sm">City</label>
    <div>
        <input type="text" class="form-control required input-sm" name="city" value="{{ emptyStr($address->city) }}">
    </div>    
</div>

<div class="form-group required col-xs-6 input-group-sm">
    <label class="control-label input-sm">State</label>
    <div>
        <input type="text" class="form-control required input-sm" name="state" value="{{ emptyStr($address->state) }}">
    </div>    
</div>

<div class="form-group required col-xs-6 input-group-sm">
    <label class="control-label input-sm">Zip/Postal Code</label>
    <div>
        <input type="text" class="form-control input-sm required-integer" name="zipcode" value="{{ emptyStr($address->zipcode) }}">
    </div>    
</div>

<div class="form-group required col-xs-6 input-group-sm">
    <label class="control-label input-sm">Country</label>
    <div>
        <input type="text" class="form-control required input-sm" name="country" value="{{ emptyStr($address->country) }}">
    </div>    
</div>

<div class="col-xs-12">
    <button type="submit" class="btn btn-success btn-sm">Submit</button>
</div>
