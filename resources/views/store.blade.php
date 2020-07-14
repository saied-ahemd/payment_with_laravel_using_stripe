@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <div class="jumbotron">
            <h1 class="display-4">Wellcom to Shopping cart!!</h1>
            <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
            <hr class="my-4">
            <p>you can see all product from her click on learn more button</p>
            <a class="btn btn-primary btn-lg" href="{{route ('products.index')}}" role="button">Learn more</a>
          </div>
    </div>
    <section>
       <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4">
        <div class="card" style="width: 22rem; height:32rem; margin-bottom:20px;">
            <img src="{{$product->image}}" class="card-img-top" alt="card image">
            <div class="card-body">
              <h5 class="card-title">{{$product->title}}</h5>
              <p class="card-text"> example text to build on the card title and make up the bulk of the card's content.</p>
              <h5> $ {{$product->price}}</h5>
              <a href="#" class="btn btn-primary">Buy</a>
            </div>
          </div>
        </div>
        @endforeach
       </div>
    </section>
</div>
@endsection