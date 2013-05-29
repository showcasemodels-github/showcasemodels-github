<?php
require_once 'shoppingCartItem.php';

class shoppingCart
{
	public $tax = 12.5; 
	public $items = array();
	public $is_unit_price_all_taxes_included = false;
	
//=====================================================================================

	  public function addItem($item)
	  {
	    $existingItem = $this->getItem($item->product_id);
	    if ($existingItem)  {
	      $existingItem->addQuantity($item->getQuantity());
	    }
	    else
	    {
	      $this->items[] = $item;
	    }
	  }
	  
//=====================================================================================
	  
	  public function deleteItem($product_id)
	  //public function deleteItem($grouping, $sectionBase, $id)
	  {
	    foreach (array_keys($this->items) as $i)
	    {
	    	//THIS DOESNT WORK BECAUSE WE DELETE FROM SOME WHERE ELSE 
	    	//PLUS I THINK THAT THE ID SHOULD BE UNIQUE ENOUGH......
	    	//EVEN THOUGH ITS NOT GUARANTEED TO BE UNIQUE	
	      //if (		$this->items[$i]->grouping == $grouping 
	      //		&&	$this->items[$i]->sectionBase == $sectionBase 
	      //		&& 	$this->items[$i]->id == $id
	      //	 )
	      
	    if ($this->items[$i]->product_id == $product_id)
	      {
	        unset($this->items[$i]);
	      }
	    }
	  }
	  
//=====================================================================================
	
	public function getNumberOfItems($countQuantities = false)
	{
	    if ($countQuantities)
	    {
	      $itemCount = 0;
	      foreach ($this->items as $item)
	      {
	        $itemCount += $item->quantity;
	      }
	      return $itemCount;
	    }
	    return count($this->getItems());
	}
	  
//=====================================================================================
	public function getItem($product_id)
	  {
	    $ind = $this->getItemIndice($product_id);
	    return (($ind !== null) ? $this->items[$ind] : null);
	  }
	  
	//=====================================================================================
	  public function getItemIndice($product_id)
	  {//NO GUARANTEE OF UNIQUENESS, COULD BE WRITTEN FAR MORE EFFICIENTLY TOO
	    $ind = null;
	    foreach ($this->items as $key => $item)
	    {
	       if ($item->product_id == $product_id)
	      {
	        $ind = $key;
	        break;
	      }
	    }
	    return $ind;
	  }
	//=====================================================================================
	 public function getItems()
	  {
	    // if we find item with a quantity of 0, we remove it from the shopping cart
	    $items = array();
	    foreach ($this->items as $item)
	    {
	      if ($item->getQuantity() != 0)
	      {
	        $items[] = $item;
	      }
	    }
	    return $items;
	  }  
	//=====================================================================================
	  public function getTotalPrice()
	  {
	    $total_price = 0;
	
	    foreach ($this->getItems() as $item)
	    {
	      if ($this->is_unit_price_all_taxes_included==true)
	      {
	        $total_price += $item->getQuantity() * $item->price * (1 - $item->discount / 100) / (1 + $this->tax / 100);
	      }
	      else
	      {
	        $total_price += $item->getQuantity() * $item->price * (1 - $item->discount / 100);
	      }
	    }
	    return $total_price;
	  }
	//=====================================================================================
	  public function changeQuantity($product_id,$quantity)
	  {
	    $item = $this->getItem($product_id);
	  	$item->setQuantity($quantity);
	  }
  
}
?>