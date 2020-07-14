@extends('layouts.app')

@section('content')

    @foreach ($carts as $cart)
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table table-striped mt-2 mb-2 table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantities</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart->items as $item)
                                       <tr>
                                           <td>{{$item['title']}}</td>
                                           <td>{{$item['price']}}</td>
                                           <td>{{$item['Qty']}}</td>
                                           <td>Paid</td>
                                       </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>
                    </div>
                   <p class="badge badge-pill mb-3 p-3 text-white badge-info">Total Price $ {{$cart->totalPrice}}</p>
                </div>
            </div>
        </div>
    @endforeach

@endsection
