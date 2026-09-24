<?php

class Cart {

	private $_CartItems = array();
	
	function __construct() {
	}
	
	private function initCart() {
		if(isset($_SESSION["ppyCart"])) {
			$this->_CartItems = $_SESSION["ppyCart"];
		}
		reset($this->_CartItems);
	}
	
	//- Agrega items al carrito
	public function AddItem($id, $titulo, $price, $quantity) {
		$this->initCart();
		$n = 0;
		if(count($this->_CartItems) > 0) {
			foreach($this->_CartItems as $Item) {
				$exists = $Item['id'] == $id ? true : false;
				if($exists) {
					$x = $n;
				}
				$n++;
			}
		}

		if(isset($x)) {			
			$ActualQuantity = $this->_CartItems[$x]['quantity'];
			$this->_CartItems[$x] = array("id" => $id, "titulo" => $titulo, "price" => $price, "quantity" => $ActualQuantity+$quantity);
		} else {
			$this->_CartItems[] = array("id" => $id, "titulo" => $titulo, "price" => $price, "quantity" => $ActualQuantity+$quantity);
		}
		
		$_SESSION["ppyCart"] = $this->_CartItems;
	}
	
	//-- Lista items en el carrito
	public function GetCartItems() {
		return $_SESSION["ppyCart"];
	}
	
	//--Borra item del carrito
	public function DeleteItem($id) {
		$this->initCart();
		$ActualItems = $this->_CartItems;
		$this->EmptyCart();

		foreach($ActualItems as $Item) {
			if($id != $Item['id']) {
				$this->_CartItems[] = array("id" => $Item['id'], "titulo" => $Item['titulo'], "price" => $Item['price'], "quantity" => $Item['quantity']);
			}			
		}

		$_SESSION["ppyCart"] = $this->_CartItems;
	}	
	
	//-- devuelve el total de productos en el carrito
	public function TotalItems() {		
		$this->initCart();

		foreach($this->_CartItems as $Item) {
			$Total += $Item['quantity'];
		}
		
		return $Total;
	}
	
	//-- devuelve el total
	public function TotalSuma() {
		$this->initCart();

		foreach($this->_CartItems as $Item) {
			$Total += $Item['quantity'] * $Item['price'];
		}
		
		return $Total;
	}
	
	//--vacia el carrito
	public function EmptyCart() {
		unset($_SESSION["ppyCart"], $this->_CartItems);
		$this->_CartItems = array();
	}
	
	//--modidica cantidad de items en el carrito
	public function UpdateQuantity($id, $qty) {
		$this->initCart();
		$ActualItems = $this->_CartItems;
		$this->EmptyCart();
		
		foreach($ActualItems as $Item) {
			$quantity = $id == $Item['id'] ? $qty : $Item['quantity'];
			
			if($quantity > 0) {
				$this->_CartItems[] = array("id" => $Item['id'], "titulo" => $Item['titulo'], "price" => $Item['price'], "quantity" => $quantity);
			}
			$Total = $Total+$quantity;			
		}
		if($Total > 0) {
			$_SESSION["ppyCart"] = $this->_CartItems;
		}
	}
	
}

?>