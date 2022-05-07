<?php
//Koristenje get i set metoda na klasi Product


class Product
{
    private $sku;
    private $quantity;
    private $name;
    private $price;


	public function setSku($sku){
		$this->sku = $sku;
	}
    public function getSku(){
		return $this->sku;
	}


	public function setQuantity($quantity){
		$this->quantity = $quantity;
	}
    public function getQuantity(){
		return $this->quantity;
	}


    public function setName($name){
		$this->name = $name;
	}
	public function getName(){
		return $this->name;
	}

	
    public function setPrice($price){
		$this->price = $price;
	}
	public function getPrice(){
		return $this->price;
	}
} 