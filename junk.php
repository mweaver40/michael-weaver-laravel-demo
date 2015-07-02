 @if(isset($cart))
    <form class="form" method="post" action="{{URL::route('getCart')}}">

        <div>
            <!--
            <div class="col-md-3 col-lg-3 hidden-xs hidden-sm" ></div>
           
            <div class="col-md-3 col-lg-3 col-sm-5 col-xs-5"><h4>Product</h4></div>
           
            <div class="col-md-2 col-sm-2 col-lg-2 hidden-xs" ><h4>Quantity</h4></div>
            <div class="hidden-lg hidden-md hidden-sm col-xs-2"><h4>#</h4></div>
            
            <div class="col-md-4 col-sm-5 col-lg-4 col-xs-5"><h4>Price</h4></div>
            -->
        </div>
        <!--
        <div class="row"><hr/></div>
        @foreach($cart->items as $item ) 
        <div>
            <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">image</div>
            <div class="col-md-3 col-lg-3 col-sm-5 col-xs-5">{{$item->catalog->name}}</div>
            <div class="col-lg-2 col-sm-2 col-xs-2 col-md-2"><input type="text"  name="quantity" style="width: 30%"  id="quantity" value={{$item->quantity}}></div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">$1000.00</div>
          
            
            <div class="col-lg-2 col-sm-2 col-xs-2 col-md-2"><a href="#"><span class="glyphicon glyphicon-trash"></span></a></div> 
        </div>
        @endforeach
        -->
    </form>
    @else
    <div>
        <p><h3>Cart is empty</h3></p>
    </div>
    @endif

    
    <label for="quantity">Qty:</label>
                    <input type="text"  name="quantity" style="width: 15%"  id="quantity" value="1">
    