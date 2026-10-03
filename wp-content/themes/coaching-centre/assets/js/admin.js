/**
 * Admin behaviour: inline status changes, delete confirmation and the
 * read/unread toggle, all handled with fetch() against admin-ajax.php.
 */
( function ( $ ) {
	'use strict';

	var cfg = window.ccAdmin || {};

	function notify( message, isError ) {
		var box = $( '#cc-notice' );

		if ( ! box.length ) {
			box = $( '<div id="cc-notice" class="notice is-dismissible" style="position:fixed;right:16px;bottom:16px;z-index:99999"><p></p></div>' )
				.appendTo( 'body' );
		}

		box.removeClass( 'notice-success notice-error' )
			.addClass( isError ? 'notice-error' : 'notice-success' )
			.find( 'p' )
			.text( message )
			.end()
			.stop( true, true )
			.fadeIn( 120 );

		window.clearTimeout( box.data( 'timer' ) );
		box.data( 'timer', window.setTimeout( function () {
			box.fadeOut( 250 );
		}, 4000 ) );
	}

	function post( action, data ) {
		return $.ajax( {
			url: cfg.ajaxUrl,
			method: 'POST',
			dataType: 'json',
			data: $.extend( { action: action, nonce: cfg.nonce }, data || {} )
		} );
	}

	/* Status dropdown in the registrations table. */
	$( document ).on( 'change', '.cc-status-select', function () {
		var select = $( this );
		var id = select.data( 'id' );
		var previous = select.data( 'prev' ) || select.val();

		select.prop( 'disabled', true );

		post( 'cc_status', { id: id, status: select.val() } )
			.done( function ( response ) {
				if ( response && response.success ) {
					select.data( 'prev', select.val() );
					notify( response.data.message, false );
					$( '.cc-pill' ).filter( '[data-id="' + id + '"]' )
						.text( response.data.label )
						.attr( 'class', 'cc-pill cc-' + response.data.status );
				} else {
					select.val( previous );
					notify( ( response && response.data && response.data.message ) || cfg.error, true );
				}
			} )
			.fail( function () {
				select.val( previous );
				notify( cfg.error, true );
			} )
			.always( function () {
				select.prop( 'disabled', false );
			} );
	} );

	/* Permanent delete. */
	$( document ).on( 'click', '.cc-delete', function () {
		var button = $( this );
		var id = button.data( 'id' );

		if ( ! window.confirm( cfg.confirm ) ) {
			return;
		}

		button.prop( 'disabled', true );

		post( 'cc_delete', { id: id } )
			.done( function ( response ) {
				if ( response && response.success ) {
					button.closest( 'tr' ).fadeOut( 150, function () {
						$( this ).remove();
					} );
					notify( response.data.message, false );
				} else {
					button.prop( 'disabled', false );
					notify( ( response && response.data && response.data.message ) || cfg.error, true );
				}
			} )
			.fail( function () {
				button.prop( 'disabled', false );
				notify( cfg.error, true );
			} );
	} );

	/* Read / unread toggle in the messages table. */
	$( document ).on( 'click', '.cc-read-toggle', function () {
		var button = $( this );
		var id = button.data( 'id' );

		button.prop( 'disabled', true );

		post( 'cc_toggle_read', { id: id } )
			.done( function ( response ) {
				if ( ! response || ! response.success ) {
					notify( ( response && response.data && response.data.message ) || cfg.error, true );
					return;
				}

				var isRead = 1 === response.data.read;

				button.data( 'read', isRead ? '1' : '0' )
					.text( isRead ? button.data( 'label-read' ) : button.data( 'label-unread' ) );

				button.closest( 'tr' ).toggleClass( 'cc-unread', ! isRead );
				notify( response.data.message, false );
			} )
			.fail( function () {
				notify( cfg.error, true );
			} )
			.always( function () {
				button.prop( 'disabled', false );
			} );
	} );

	/* Remember the first value of every status dropdown on load. */
	$( function () {
		$( '.cc-status-select' ).each( function () {
			$( this ).data( 'prev', $( this ).val() );
		} );

		$( '.cc-read-toggle' ).each( function () {
			var button = $( this );
			var isRead = '1' === String( button.data( 'read' ) );

			button.data( 'label-read', button.text() );
			button.data( 'label-unread', isRead ? 'অপঠিত' : 'পঠিত' );
		} );
	} );
}( jQuery ) );