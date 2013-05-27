<?
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';require_once 'subcategoryView.php';require_once 'Project/Model/Articles/subcategory.php';

class subcategoryController extends applicationsSuperController
{
	public function indexAction()
	{
		header('Location: /articles');
	}
	
//-------------------------------------------------------------------------------------------------

	public function addAction()	{		var_dump($_POST);		if($_POST['title'] != '')		{			$subcategory = new subcategory();			$subcategory->__set('category_id', $_POST['category_id']);			$subcategory->__set('subcategory_title', $_POST['title']);			$subcategory->__set('subcategory_url', $this->replaceChars($_POST['subcategory_url']));
			$subcategory->insert();			$this->logEvent("ADDED Sub-category {$_POST['title']}");		}		header('Location: /articles/subcategory/edit/'.$subcategory->__get('subcategory_id'));	}
	
//-------------------------------------------------------------------------------------------------

	public function editAction()	{		$subcategory_id = $this->getValueOfURLParameterPair('edit');
		if(!is_numeric($subcategory_id))			$this->indexAction();
		$subcategory = new subcategory();		$subcategory->__set('subcategory_id', $subcategory_id);		$subcategory->select();
		if(isset($_POST['edit_subcategory']))
		{
			$subcategory->__set('subcategory_title', $_POST['title']);
			$subcategory->__set('description', $_POST['description']);
			$subcategory->__set('subcategory_url', $this->replaceChars($_POST['subcategory_url']));
			$subcategory->update();
			
			$this->logEvent("UPDATED Sub-category {$subcategory_id}");
		}
		
		$view = new subcategoryView();
		$view->_set('subcategory', $subcategory);
		$view->displaySubCategoryEditor();
	}
	
//-------------------------------------------------------------------------------------------------

	public function deleteAction()
	{
		$subcategory_id = $this->getValueOfURLParameterPair('delete');
		
		if(!is_numeric($subcategory_id))
			$this->indexAction();
		
		$subcategory = new subcategory();
		$subcategory->__set('subcategory_id', $subcategory_id);
		$subcategory->delete();
			
		$this->logEvent("DELETED Sub-category {$_POST['subcategory_id']}");
		
		header('Location: /articles');
	}
	
//-------------------------------------------------------------------------------------------------

	public function logEvent($message)
	{
		try
		{
			$fh = fopen(STAR_SITE_ROOT."/Project/2_Enterprise/Code/Applications/Articles/Controllers/subcategory/log.txt", 'a') or die('no such file');
			$stringData = $_SERVER['REMOTE_ADDR'].": ".date("F j, Y, g:i a")." - {$message}\n";
			fwrite($fh, $stringData);
			fclose($fh);
		} 
		catch (Exception $e) { print $e->getTraceAsString(); }
	}
	
//-------------------------------------------------------------------------------------------------	
	
	private function replaceChars($permalink)
	{
		$characters = array(' ','_',',','\'','.',':',';','?','!');
		
		$string = strtolower(str_replace($characters, '-', $permalink));
		
		return trim($string, '-');
	}
}


?>