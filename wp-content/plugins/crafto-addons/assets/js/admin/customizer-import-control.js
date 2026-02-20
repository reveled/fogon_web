( function( $ ) {
	
	"use strict";
	
	// Export code
	$( document ).on( 'click', 'input[name=crafto-export-button]', function() {
		window.location.href = craftoImportExport.customizeurl + '?crafto-export=' + craftoImportExport.exportnonce;
	});

	// Import code
	$( document ).on( 'click', 'input[name=crafto-import-button]', function() {

		const $importFileInput = $( 'input[name=crafto-import-file]' );
		const form             = $( '<form class="crafto-form" method="POST" enctype="multipart/form-data"></form>' );
		const $controls        = $( '.crafto-import-controls' );
		const fileName         = $importFileInput.val();

		if ( ! fileName ) {
			alert( craftoImportExport.blankFileError );
			return;
		}

		if ( fileName.match(/\.json$/i) ) {
			$( window ).off( 'beforeunload' );
			$( 'body' ).append( form );
			form.append( $controls );
			$( '.crafto-uploading' ).show();
			form.submit();
		} else {
			alert( craftoImportExport.validFileError );
		}
	});

})( jQuery );
