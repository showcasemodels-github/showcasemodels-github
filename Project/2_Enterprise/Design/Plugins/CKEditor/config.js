/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	var removeButton = '';
	
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
	    { name: 'document',	   groups: [ 'mode' ] },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'styles' }
		];
		
	//Remove the image button when in Content Manager Page
	var currentPage	= $('body').attr('id');
	
	//if(currentPage == 'cms'){ removeButton = 'Image,';	}
	
		// Remove some buttons, provided by the standard plugins, which we don't
		// need to have in the Standard(s) toolbar.
		config.removeButtons = removeButton+'Document,DocTools,Save,NewPage,Flash,Smiley,Iframe,PageBreak,Preview,Print,CreateDiv,FontSize,Font,Copy,Cut,Undo,Redo';
};


CKEDITOR.on( 'dialogDefinition', function( ev )
		   {
		      // Take the dialog name and its definition from the event data.
		      var dialogName = ev.data.name;
		      var dialogDefinition = ev.data.definition;
		      
		      // Check if the definition is from the dialog we're
		      // interested in (the 'image' dialog). This dialog name found using DevTools plugin
		      if ( dialogName == 'image' )
		      {
		    	  
		    	 $('.cke_dialog_background_cover').remove();
		    	// Remove the 'Link' and 'Advanced' tabs from the 'Image' dialog.
		         dialogDefinition.removeContents( 'link' );
		         dialogDefinition.removeContents( 'advanced' );
		  
		         // Get a reference to the 'Image Info' tab.
		         var infoTab = dialogDefinition.getContents( 'info' );
		  
		         // Remove unnecessary widgets/elements from the 'Image Info' tab.         
		         infoTab.remove( 'txtHSpace');
		         infoTab.remove( 'txtVSpace');
		      }
		   });
