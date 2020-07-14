@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">      
      @if ($cart)
      <div class="col-md-8">
          @if ($errors->any())
              <div class="alert-danger">
                 <ul>
                    @foreach ($errors->all() as $error)
                       <li>{{$error}}</li>
                    @endforeach
                 </ul>
              </div>
          @endif
          @foreach ($cart->items as $product)
          <div class="card" style=" margin-bottom:20px;">
          <div class="card-body">
            <div class="justify-content-between d-flex">
                <h5 class="card-title ">{{$product['title']}}</h5>
                <p class="float-right lead"> $ {{$product['price']}}</p>
            </div>
            <div class="card-text">
                <form action="{{route('product.update',$product['id'])}}" method="POST" style="margin: 0px">
                    @csrf
                    @method('put')
                    <input type="text" name="Qty" id="Qty" value="{{$product['Qty']}}">
                    <button type="submit" class="btn btn-secondary ml-1 btn-sm">Change</button>
               </form>
                <form action="{{route('product.destroy',$product['id'])}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger ml-4 btn-sm float-right confirm">remove</button>
               </form>
              </div>
          </div>
        </div>
          @endforeach
         <h5><strong>Total: $ {{$cart->totalPrice}}</strong></h5>

      </div>
      <div class="col-md-4">
          <div class="card bg-primary text-white">
              <div class="card-body">
                  <div class="card-title">
                      <h3>
                          Your cart
                          <hr>
                      </h3>
                  </div>
                  <div class="card-text">
                      <p>
                          Total Amount is ${{$cart->totalPrice}}
                      </p>
                      <p>
                          Total Quantities is {{$cart->totalQty}}
                      </p>
                      {{-- send the tatoal money to the check out route--}}
                      <a href=" {{ route('cart.checkout',$cart->totalPrice)}}" class="btn btn-info">Checkout</a>
                  </div>
              </div>

          </div>

      </div>
          
      @else
          <p class="alert alert-warning">there are no items in the cart</p>
      @endif
       
   </div>
</div>
@endsection