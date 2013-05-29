
<?php
class shoppingCartItem
{
  public $quantity = 0;
  public $price = 0; //price needs to be set in case it changes during an edit and breaks the client contract
  public $discount = 0;
  
  
  public $product_id = 0; //item id will take on the id of the product its representing in the database
  
  public function __construct($product_id)
  {
    $this->product_id = $product_id;
  }
  
  //===================================================================================================
  //		QUANTTY
  //  
  public function getQuantity()
  {
    return $this->quantity;
  }
  //------------------------------------------------------------------------------------
  public function setQuantity($quantity)
  {
	    if (!preg_match('~^\d+$~', $quantity))
	    {
	      $this->quantity = 1;
	    }
	    else
	    {
	      $this->quantity = $quantity;
	    }
  }
  //------------------------------------------------------------------------------------
  public function addQuantity($quantity)
  {
    $this->quantity += $quantity;
  }
  //===================================================================================================
  public function storeObjectItem($objectItem)
  {
  	$this->objectItem = $objectItem; 
  }
  
  public function getObjectItem()
  {
  	return $this->objectItem;
  }
  //===================================================================================================  
}
?>