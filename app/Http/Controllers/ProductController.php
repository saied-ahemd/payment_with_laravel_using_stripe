<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Cart;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();

        return view('products.index',['products'=> $products]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    //this function ti show the cart content (all product in the cart)
    public function show()
    {
        if(session()->has('Cart')){
            //pass the cart to the class cart if the user was used it before
            $cart=new Cart(session()->get('Cart'));
        }else{
            $cart= null;
        }
        return view('cart.show',compact('cart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'Qty' => 'required|numeric',
        ]);
        $cart = new Cart(session()->get('Cart'));
        
        $cart->updateQty($product->id,$request->Qty);

        session()->put('Cart',$cart);

        return redirect()->route('cart.show')->with('success','the product has been removed successfuly');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $cart = new Cart(session()->get('Cart'));
        $cart->remove($product->id);

        //check if this was the only item in the cart you have if this happen destoey the session
        if($cart->totalQty<=0){
            session()->forget('Cart');
        }else{
            session()->put('Cart',$cart);

        }
        return redirect()->route('cart.show')->with('success','the product has been removed successfuly');

    }

    public function addToCart(Product $product){
        if(session()->has('Cart')){
            //pass the cart to the class cart if the user was used it before
            $cart=new Cart(session()->get('Cart'));
        }else{
            $cart= new Cart();
        }
        $cart->add($product);
       
       //add cart to the session
       session()->put('Cart',$cart);
       return redirect()->route('products.index')->with('success','the product added successfuly');
    }
    public function checkout($amount)
    {
      return view('cart.checkout',compact('amount'));
    }
    public function charge(Request $request)
    {
        
        $charge =Stripe::charges()->create([
            'currency' => 'USD',
            'source' =>$request->stripeToken,
            'amount' =>$request->amount,
            'description' => 'test from laravel app',
        ]);
        $chargeID=$charge['id'];
        if($chargeID){
            // save order in order tables
            auth()->user()->orders()->create([
                'cart' => serialize(session()->get('Cart')),
            ]);
            //  clear the cart
            session()->forget('Cart');
            return redirect()->route('store')->with('success','payment was done, thanks.');
        }else{
            return redirect()->back();

        }
    }
}
