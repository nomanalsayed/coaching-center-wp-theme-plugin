/**
 * Live preview inside the Customizer.
 *
 * Every setting is a theme mod, so the preview simply re-renders the markup
 * the templates output instead of reloading the whole preview frame.
 */
( function ( $ ) {
	'use strict';

	if ( ! window.wp || ! wp.customize ) {
		return;
	}

	var api = wp.customize;

	/**
	 * Replace the text of the first element matching a selector.
	 *
	 * @param {string} selector CSS selector.
	 * @param {string} value    New value.
	 */
	function setText( selector, value ) {
		api( selector, function ( setting ) {
			setting.bind( function ( next ) {
				var node = document.querySelector( selector );

				if ( ! node ) {
					return;
				}

				node.textContent = next || '';
			} );
		} );
	}

	/**
	 * Toggle a section's visibility.
	 *
	 * @param {string} selector CSS selector.
	 * @param {string} setting  Setting id.
	 */
	function toggleVisible( selector, setting ) {
		api( setting, function ( value ) {
			value.bind( function ( next ) {
				var node = document.querySelector( selector );

				if ( node ) {
					node.hidden = ! next;
				}
			} );
		} );
	}

	$( function () {
		/* Selectors use the data-cc attribute so we never have to guess IDs. */
		setText( '[data-cc="logo_text"]', 'cc_logo_text' );
		setText( '[data-cc="phone"]', 'cc_phone' );
		setText( '[data-cc="email"]', 'cc_email' );
		setText( '[data-cc="address"]', 'cc_address' );

		setText( '[data-cc="hero_tag"]', 'cc_hero_tag' );
		setText( '[data-cc="hero_title"]', 'cc_hero_title' );
		setText( '[data-cc="hero_text"]', 'cc_hero_text' );
		setText( '[data-cc="hero_btn1_txt"]', 'cc_hero_btn1_txt' );
		setText( '[data-cc="hero_btn2_txt"]', 'cc_hero_btn2_txt' );

		setText( '[data-cc="programs_title"]', 'cc_programs_title' );
		setText( '[data-cc="programs_sub"]', 'cc_programs_sub' );

		setText( '[data-cc="features_title"]', 'cc_features_title' );
		setText( '[data-cc="features_sub"]', 'cc_features_sub' );

		setText( '[data-cc="exam_title"]', 'cc_exam_title' );
		setText( '[data-cc="exam_text"]', 'cc_exam_text' );

		setText( '[data-cc="cadet_tag"]', 'cc_cadet_tag' );
		setText( '[data-cc="cadet_title"]', 'cc_cadet_title' );
		setText( '[data-cc="cadet_text"]', 'cc_cadet_text' );

		setText( '[data-cc="teachers_title"]', 'cc_teachers_title' );
		setText( '[data-cc="teachers_sub"]', 'cc_teachers_sub' );
		setText( '[data-cc="quotes_title"]', 'cc_quotes_title' );
		setText( '[data-cc="quotes_sub"]', 'cc_quotes_sub' );

		setText( '[data-cc="cta_title"]', 'cc_cta_title' );
		setText( '[data-cc="cta_text"]', 'cc_cta_text' );
		setText( '[data-cc="faq_title"]', 'cc_faq_title' );

		setText( '[data-cc="footer_about"]', 'cc_footer_about' );
		setText( '[data-cc="copyright"]', 'cc_copyright' );

		toggleVisible( '[data-cc="exam"]', 'cc_exam_title' );
		toggleVisible( '[data-cc="cadet"]', 'cc_cadet_title' );
	} );
}( jQuery ) );