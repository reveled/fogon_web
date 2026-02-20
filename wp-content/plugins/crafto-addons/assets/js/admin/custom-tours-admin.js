! function( $ ) {

	"use strict";

	$( document ).ready( function() {
		function tourActivityIcon( state ) {
			if ( ! state.id ) {
				return state.text;
			}

			let icontext = state.text;

			let iconTextHTML = '<span>';
				iconTextHTML += '<i class="';
				iconTextHTML += state.element.value;
				iconTextHTML += '"></i>  ';
				iconTextHTML += icontext;
				iconTextHTML += '</span>';

			state = $( iconTextHTML );
			return state;
		};

		const $crafto_activity_icon = $( '#crafto_activity_icon' );
		if ( $crafto_activity_icon.length > 0 ) {
			$crafto_activity_icon.select2({
				placeholder: CraftoToursAdmin.i18n.placeholder,
				allowClear: true,
				templateResult: tourActivityIcon,
				templateSelection: tourActivityIcon,
				width: '50%',
			} );
		}
	});
}( window.jQuery );
