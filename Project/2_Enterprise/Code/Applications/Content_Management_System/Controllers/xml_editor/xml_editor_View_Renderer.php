<?php
require_once FILE_ACCESS_CORE_CODE.'/Framework/MVC_superClasses_Core/viewSuperClass_Core/viewSuperClass_Core.php';

class xml_editor_View_Renderer extends viewSuperClass_Core
{
	
	
	public function __construct()
	{
		
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/Content_Management_System/Controllers/xml_editor/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('PAGE EDITOR CS'=>$content));
		
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/Content_Management_System/Controllers/xml_editor/templates/js_links.phtml');
		response::getInstance()->addContentToStack('global_javascript_bottom',array('PAGE EDITOR JS'=>$content));
	}
	
	
	public function get_xml_file($xmlObj) {
	
		
		$content = '';
		$content .= '<span class="element_description fleft pTxl pLl">XML</span>';
		$content .= '<form method="post" id="textareaautogrow">';
		$content .= '<textarea name="dataString" id="wholefileview" >';
		$content .= print_r($xmlObj->asXML(),true);
		$content .= '</textarea>';
		$content .= '<input  type="submit" name="save" class="save mTxxl mBm"/>';
		$content .= '</form>';
		$content .= $this->getJavascriptEditor("XML");
	
		return $content;
	}
	
	private function getJavascriptEditor($codetype) {
		$content ='';
		$content .= '<script type="text/javascript">';
		$content .= 'editAreaLoader.init({';
		$content .= 'id : "wholefileview"'; 		// textarea id
		$content .= ',syntax: "'.$codetype.'"'; 	// syntax to be uses for highgliting
		$content .= ',start_highlight: true	';      // to display with highlight mode on start-up
		$content .= ',min_height: 480	';
		$content .= ',font_size: 9	';
		$content .= ',word_wrap: true	';
		$content .= ',toolbar: "search, select_font , highlight, reset_highlight"';
		$content .= ',allow_toggle:false';
		$content .= '});';
		$content .= '</script>';
		return $content;
	}
	
	
}

?>