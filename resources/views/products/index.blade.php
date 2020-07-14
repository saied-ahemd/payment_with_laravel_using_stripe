@extends('layouts.app')

@section('content')
<div class="container">
    <section>
      @if (session()->has('success'))
             <div class="alert alert-success">{{session()->get('success')}}</div>
         @endif
       <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4">
        <div class="card" style="width: 22rem; height:32rem; margin-bottom:20px;">
            <img src="{{$product->image}}" class="card-img-top" alt="card image">
            <div class="card-body">
              <h5 class="card-title">{{$product->title}}</h5>
              <p class="card-text"> example text to build on the card title and make up the bulk of the card's content.</p>
              <h5> $ {{$product->price}}</h5>
              <a href="{{route('cart.add',$product->id)}}" class="btn btn-primary">Buy</a>
            </div>
          </div>
        </div>
        @endforeach
       </div>
    </section>
</div>
@endsection