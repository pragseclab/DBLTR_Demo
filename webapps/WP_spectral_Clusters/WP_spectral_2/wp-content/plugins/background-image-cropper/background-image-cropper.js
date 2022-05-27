(function( wp, $ ){
	'use strict';

	if ( ! wp || ! wp.customize ) { return; }

	// Set up our namespace.
	var api = wp.customize;

	api.croppingBackgroundImageControl = api.CroppedImageControl.extend({

		/**
		 * Prevent attachment param from being deleted due to non-numeric setting value by copying the rest of the parent ready() directly.
		 * 
		 * This seems to be the best way to work around a bug caused by https://core.trac.wordpress.org/ticket/36521.
		 *
		 * @param {number|string} value Attachment
		 */
		ready: function() {
			var control = this;
			// Shortcut so that we don't have to use _.bind every time we add a callback.
			_.bindAll( control, 'restoreDefault', 'removeFile', 'openFrame', 'select', 'pausePlayer' );

			// Bind events, with delegation to facilitate re-rendering.
			control.container.on( 'click keydown', '.upload-button', control.openFrame );
			control.container.on( 'click keydown', '.upload-button', control.pausePlayer );
			control.container.on( 'click keydown', '.thumbnail-image img', control.openFrame );
			control.container.on( 'click keydown', '.default-button', control.restoreDefault );
			control.container.on( 'click keydown', '.remove-button', control.pausePlayer );
			control.container.on( 'click keydown', '.remove-button', control.removeFile );
			control.container.on( 'click keydown', '.remove-button', control.cleanupPlayer );
			
			// The rest of the core ready method is the part we need to avoid here or isn't relevant to this control.
		},

		/**
		 * Updates the setting and re-renders the control UI.
		 *
		 * Save the image to the setting instead of the attachment id.
		 *
		 * @param {object} attachment
		 */
		setImageFromAttachment: function( attachment ) {
			var control = this;
			control.params.attachment = attachment;

			// Set the Customizer setting.
			control.setting( attachment.sizes.full.url );

			// The controls isn't automatically rendered for some reason, so do it manually.
			control.renderContent();

			// Set the background-image context via Ajax (copied from core control).
			wp.ajax.post( 'custom-background-add', {
				nonce: _wpCustomizeBackground.nonces.add,
				wp_customize: 'on',
				customize_theme: api.settings.theme.stylesheet,
				attachment_id: control.params.attachment.id
			} );
		}

	});
	
	/**
	 * Extends wp.customizer.controlConstructor with control constructor for
	 * background_image.
	 */
	$.extend( api.controlConstructor, {
		background: api.croppingBackgroundImageControl // Note: this overrides the WP_Customize_Background_Image_control, which is removed in PHP anyway, because of the way the customizer media CSS works
	});
})( window.wp, jQuery );