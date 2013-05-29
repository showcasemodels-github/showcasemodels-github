<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class commerceAjaxView extends applicationsSuperView
{
	private $content = '';
	
	//-------------------------------------------------------------------------------------------------
	
	public function __get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
	
		else return NULL;
	}
	
	//-------------------------------------------------------------------------------------------------
	
	public function displayShoppingCartItems($cart_items, $number_of_items, $total_price)
	{
		for($i=0;$i<$cart_items;$i++)
		{ 
			$this->content .= '<div class="dropDownContent">';
			$this->content .= $_SESSION['cart'][$i][0]['product_name'];	
			$this->content .=	'<div class="cartDropImage" style="background-image:url(/Data/Images/'.image::selectImageFullPath($_SESSION['cart'][$i][0]['product_id']).')"></div>';
			$this->content .= $_SESSION['cart'][$i][0]['quantity'];
			$this->content .= '</div>';
		}
			$this->content .= '<div class="clearfix">
				<a href="/shop/cart" class="">Show Cart</a>
				|
				<a href="/shop/checkout" class="">Check Out</a>';
				$this->content .= '<div class="clearfix mTs">Total quantity: '.$number_of_items.'</div>';
				$this->content .= '</div>';
				$this->content .= '<div class="clearfix ">Total price: '.$total_price.' :Php</div>';
				$this->content .= '</div>';
			$this->content .= '</div>';
	}
}
?>