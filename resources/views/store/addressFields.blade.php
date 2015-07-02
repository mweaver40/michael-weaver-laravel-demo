
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

<div class="form-group col-xs-6 input-group-sm">
    <label class="control-label input-sm">Telephone</label>
    <div>
        <input type="text" class="form-control required-integer input-sm" name="telephone" value="{{ old('telephone') }}">
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