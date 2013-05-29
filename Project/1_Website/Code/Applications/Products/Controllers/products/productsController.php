<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'productsView.php';
require_once 'productsModel.php';

require_once 'Project/Model/Products/category.php';
require_once 'Project/Model/Products/subcategories.php';
require_once 'Project/Model/Products/product.php';
require_once 'Project/Model/Products/products.php';
require_once 'Project/Model/Routes/route.php';

require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';

class productsController extends applicationsSuperController
{
	private $url_parameter;
	private $array_of_related_products;
	
	public function __construct()
	{
		parent::__construct();
		$this->url_parameter = routes::getInstance()->_pathInfoArray;
	}
	
	public function indexAction()
	{	
		if(count($this->url_parameter) == 1)
		{ 
			//homepage
			$product_title = ucwords(str_replace('-', ' ', $this->url_parameter[0]));
			$product = new productsModel(); 
			$product->checkIfProduct($product_title);
			
			$is_product = $product->__get('is_product');
			
			if($is_product != 1)
			{
				//if url_parameter is not product
				$product->__set('permalink', $this->url_parameter[0]);
				$product->getCategoryID(); 
				$product->selectProducts();
				$product->selectName($this->url_parameter[0]);
				$product->selectDescription($this->url_parameter[0]);
				
				//display list of subcategories of the product
				$product->selectSubcategories();
				//var_dump( $product->__get('array_of_subcategories'));die;
				$productsView = new productsView();
				$productsView->_set('description', $product->__get('description'));
				$productsView->_set('category_name', $product->__get('category_name'));
				$productsView->_set('description', $product->__get('description'));
				$productsView->_set('url_parameter', $this->url_parameter[0]);
				$productsView->_set('array_of_subcategories', $product->__get('array_of_subcategories'));
				$productsView->_set('array_of_products', $product->__get('array_of_products'));
				$productsView->displayProductByCategory();
			}
			elseif($is_product == 1) 
			{
				$this->displayProductDetailsAction();
			}
			else 
			{
				header('Location: /');
			}
		}
		elseif(count($this->url_parameter) == 2)
		{	
			//with subcategory
			$subcategory = new productsModel(); 
			$subcategory->__set('permalink', $this->url_parameter[1]);
			$subcategory->getSubCategoryID();
			$subcategory->selectProducts();
			$subcategory->getSubcategoryName();
			$subcategory->getSubcategoryDescription();
			
			$productsView = new productsView();
			$productsView->_set('subcategory', $subcategory->__get('category_name'));
			$productsView->_set('subcategory_description', $subcategory->__get('description'));
			$productsView->_set('array_of_products', $subcategory->__get('array_of_products'));
			$productsView->displayProductBySubCategory();
		}
	}	
	
	public function displayProductDetailsAction()
	{
		$product = new product();
		$product->__set('permalink', $this->url_parameter[0]);
		$product->select();
		
		//get product with in same category
		$related_products = new productsModel();
		$related_products->getProductCategoryID($this->url_parameter[0]);
		$related_products->selectRandomRelatedProducts();
		
		$productsView = new productsView();
		$productsView->_set('product', $product); //var_dump($related_products->__get('array_of_random_products')); die;
		$productsView->_set('array_of_random_products', $related_products->__get('array_of_random_products'));
		$productsView->displayProductDetails();
	}
}