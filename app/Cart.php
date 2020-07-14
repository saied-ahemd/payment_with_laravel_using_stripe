<?php

namespace App;

class Cart 
{
    public $items=[];
    public $totalQty;
    public $totalPrice;
    
    public function __construct($Cart = null){
        if($Cart){

            $this->items= $Cart->items;
            $this->totalQty= $Cart->totalQty;
            $this->totalPrice= $Cart->totalPrice;
        }else{
            $this->items= [];
            $this->totalQty= 0;
            $this->totalPrice= 0;
        }

    }
    public function add($product){
        $item=[
            'id'=>$product->id,
            'title'=>$product->title,
            'price'=>$product->price,
            'Qty'=>0,
            'image'=>$product->image,

        ];
        if(!array_key_exists($product->id,$this->items)){
            $this->items[$product->id]=$item;
            $this->totalQty+= 1;
            $this->totalPrice+= $product->price;
        }else{
            $this->totalQty+= 1;
            $this->totalPrice+= $product->price;
        }
        
        $this->items[$product->id]['Qty'] +=1;
    }
    public function remove( $id)
    {
        if(array_key_exists($id,$this->items)){
            $this->totalQty-=$this->items[$id]['Qty'];
            $this->totalPrice-=$this->items[$id]['Qty'] * $this->items[$id]['price'];
            unset($this->items[$id]);

        }
    }
    public function updateQty($id,$qty)
    {
        //remove the exsit price and qty
        $this->totalQty-=$this->items[$id]['Qty'];
        $this->totalPrice-=$this->items[$id]['price'] * $this->items[$id]['Qty'];
        //add the new value of qty
        $this->items[$id]['Qty']=$qty;
        $this->totalQty+=$qty;
        $this->totalPrice+=$this->items[$id]['price'] * $qty;



    }
}
