;( function( $ ) {

	var nfRadio = Backbone.Radio;

	var toggleFields = function() {
		if ( $('#zd_anonymous').length ) {
			['#zd_auth_user', '#zd_auth_token'].forEach( function( el ) { $(el).closest('.nf-setting').toggle( ! $('#zd_anonymous').prop('checked') ); } );
		}
	}

	/**
	 * Listens for settingGroup render event to hide/show elements.
	 */
	var controller = Marionette.Object.extend( {
		initialize: function() {
			// Listen for click events on our settings group.
			this.listenTo( nfRadio.channel( 'drawer' ), 'render:settingGroup', toggleFields );
		},
	});

	$( document ).ready( function() {

		// Add events.
		$('body').on( 'change', '#zd_anonymous', toggleFields );
		new controller();
	});

})( jQuery );