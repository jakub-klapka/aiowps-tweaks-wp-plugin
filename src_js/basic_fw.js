/* global jQuery */
( function( $ ){

	var BasicFw = {

		init: function() {

			if( typeof pagenow === 'undefined' || pagenow !== 'wp-security_page_aiowpsec_firewall' ) return;

			var php_settings = ( typeof LumiAIOWPSTweaksBasicFW !== 'undefined' ) ? LumiAIOWPSTweaksBasicFW : {};

			this.settings = $.extend( {
				dont_use_server_signature_status: '0',
				dont_limit_upload_size: '0',
				__dont_use_server_signature: 'Don\'t use ServerSignature:',
				__server_signature_desc: 'Use this option if your server don\'t allow for ServerSignature directive.',
				__dont_limit_upload_size: 'Don\'t limit upload size:',
				__limit_upload_size_desc: 'Use this option if you don\'t want to limit upload file size to 10MB.'
			}, php_settings );

			this.add_checkboxes();

		},

		checkboxes_template:
			'<tr valign="top">' +
			'   <th scope="row">{{__dont_use_server_signature}}</th>' +
			'   <td>' +
			'   <input name="lumi_aiowps_tweaks_basicfw_dont_use_serversignature" type="checkbox"{{server_signature_checked}} value="0">' +
			'   <span class="description">{{__server_signature_desc}}</span>' +
			'   </td>' +
			'</tr>' +
			'<tr valign="top">' +
			'   <th scope="row">{{__dont_limit_upload_size}}</th>' +
			'   <td>' +
			'   <input name="lumi_aiowps_tweaks_basicfw_dont_use_upload_limit"{{limit_upload_checked}} type="checkbox" value="0">' +
			'   <span class="description">{{__limit_upload_size_desc}}</span>' +
			'   </td>' +
			'</tr>',

		process_template: function() {
			var output = this.checkboxes_template;
			output = output.replace( '{{server_signature_checked}}', ( ( this.settings.dont_use_server_signature_status === '1' ) ? ' checked="checked"' : '' ) );
			output = output.replace( '{{limit_upload_checked}}', ( ( this.settings.dont_limit_upload_size === '1' ) ? ' checked="checked"' : '' ) );
			output = output.replace( '{{__dont_use_server_signature}}', this.settings.__dont_use_server_signature );
			output = output.replace( '{{__server_signature_desc}}', this.settings.__server_signature_desc );
			output = output.replace( '{{__dont_limit_upload_size}}', this.settings.__dont_limit_upload_size );
			output = output.replace( '{{__limit_upload_size_desc}}', this.settings.__limit_upload_size_desc );
			return output;
		},

		add_checkboxes: function() {

			var table = $( 'input[name="aiowps_enable_basic_firewall"]' ).parents( 'table' );
			var html_append = $( this.process_template() );

			table.append( html_append );
		}

	};


	$( function(){
		BasicFw.init();
	} );

} )( jQuery );