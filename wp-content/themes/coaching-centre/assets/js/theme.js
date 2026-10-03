/**
 * Front-end behaviour for the coaching centre theme.
 *
 * Progressive enhancement only: every section works without JavaScript, this
 * file just removes the need for page reloads.
 */
( function () {
	'use strict';

	var cfg = window.ccTheme || {};
	var i18n = cfg.i18n || {};

	function q( sel, root ) {
		return ( root || document ).querySelector( sel );
	}

	function qa( sel, root ) {
		return Array.prototype.slice.call( ( root || document ).querySelectorAll( sel ) );
	}

	/* ---------------------------------------------------------------- *
	 * Smooth in-page navigation for the header navigation.
	 * ---------------------------------------------------------------- */
	function initAnchors() {
		qa( 'a[href*="#"]' ).forEach( function ( link ) {
			var href = link.getAttribute( 'href' );

			if ( ! href || href === '#' || href.length < 2 ) {
				return;
			}

			var target = q( href );

			if ( ! target ) {
				return;
			}

			link.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				target.scrollIntoView( { behavior: 'smooth', block: 'start' } );
				history.replaceState( null, '', href );
			} );
		} );
	}

	/* ---------------------------------------------------------------- *
	 * Course tab filter on the home page.
	 * ---------------------------------------------------------------- */
	function initTabs() {
		var tabs = q( '#tabs' );
		var list = q( '#plist' );

		if ( ! tabs || ! list ) {
			return;
		}

		var buttons = qa( '.tab', tabs );
		var cards = qa( '.prog', list );
		var empty = q( '#cc-programs-empty' );

		buttons.forEach( function ( button ) {
			button.addEventListener( 'click', function () {
				var filter = button.getAttribute( 'data-f' ) || 'all';
				var shown = 0;

				buttons.forEach( function ( other ) {
					other.classList.toggle( 'on', other === button );
					other.setAttribute( 'aria-selected', other === button ? 'true' : 'false' );
				} );

				cards.forEach( function ( card ) {
					var match = 'all' === filter || card.getAttribute( 'data-cat' ) === filter;

					card.hidden = ! match;

					if ( match ) {
						shown++;
					}
				} );

				if ( empty ) {
					empty.hidden = shown > 0;
				}
			} );
		} );
	}

	/* ---------------------------------------------------------------- *
	 * Dependent selects, live fee and admission steps on the registration
	 * form. Markup contract:
	 *   select[name=course_class] data-programs data-modes data-group data-fee
	 * ---------------------------------------------------------------- */
	function options( items, placeholder ) {
		var list = [ { value: '', label: placeholder } ];

		( items || [] ).forEach( function ( item ) {
			list.push( item );
		} );

		return list;
	}

	function paintOptions( select, list ) {
		if ( ! select ) {
			return;
		}

		var current = select.value;

		select.innerHTML = '';

		list.forEach( function ( item ) {
			var option = document.createElement( 'option' );

			option.value = item.value;
			option.textContent = item.label;

			if ( item.fee ) {
				option.setAttribute( 'data-fee', item.fee );
			}

			if ( item.selected || item.value === current ) {
				option.selected = true;
			}

			select.appendChild( option );
		} );
	}

	function paintModes( container, modes, current ) {
		if ( ! container ) {
			return;
		}

		container.innerHTML = '';

		if ( ! modes || ! modes.length ) {
			return;
		}

		modes.forEach( function ( mode, index ) {
			var label = document.createElement( 'label' );
			var input = document.createElement( 'input' );
			var span = document.createElement( 'span' );

			label.className = 'opt';
			input.type = 'radio';
			input.name = 'mode';
			input.value = mode;

			if ( 0 === index ) {
				input.required = true;
			}

			if ( mode === current ) {
				input.checked = true;
			}

			span.textContent = mode;
			label.appendChild( input );
			label.appendChild( span );
			container.appendChild( label );
		} );
	}

	function paintSummary( box, program, fee ) {
		if ( ! box ) {
			return;
		}

		box.innerHTML = '';

		if ( ! program ) {
			var empty = document.createElement( 'div' );

			empty.textContent = i18n.pickProg;
			box.appendChild( empty );
			return;
		}

		[
			[ i18n.program || 'প্রোগ্রাম', program ],
			[ i18n.courseFee || 'কোর্স ফি', ccMoney( fee ) ]
		].forEach( function ( pair ) {
			var row = document.createElement( 'div' );
			var left = document.createElement( 'span' );
			var right = document.createElement( 'span' );

			left.textContent = pair[ 0 ];
			right.textContent = pair[ 1 ];
			row.appendChild( left );
			row.appendChild( right );
			box.appendChild( row );
		} );

		var total = document.createElement( 'div' );
		var totalLabel = document.createElement( 'span' );
		var totalValue = document.createElement( 'span' );

		total.className = 't';
		totalLabel.textContent = i18n.total || 'মোট';
		totalValue.textContent = ccMoney( fee );
		total.appendChild( totalLabel );
		total.appendChild( totalValue );
		box.appendChild( total );
	}

	function initRegistration() {
		var classSelect = q( 'select[name="course_class"]' );

		if ( ! classSelect ) {
			return;
		}

		var programSelect = q( classSelect.getAttribute( 'data-programs' ) );
		var modeBox = q( classSelect.getAttribute( 'data-modes' ) );
		var groupBox = q( classSelect.getAttribute( 'data-group' ) );
		var summary = q( classSelect.getAttribute( 'data-fee' ) );
		var programs = cfg.programs || {};

		function currentProgram() {
			if ( ! programSelect || ! programSelect.value ) {
				return null;
			}

			var found = null;

			Object.keys( programs ).forEach( function ( key ) {
				( programs[ key ] || [] ).forEach( function ( item ) {
					if ( item.label === programSelect.value ) {
						found = item;
					}
				} );
			} );

			return found;
		}

		function syncPrograms() {
			var className = classSelect.value;
			var items = programs[ className ] || [];

			paintOptions(
				programSelect,
				options(
					items.map( function ( item ) {
						return { value: item.label, label: item.label, fee: item.fee };
					} ),
					items.length ? i18n.pickProg : i18n.noProgram
				)
			);

			if ( groupBox ) {
				groupBox.hidden = ! /৯ম|১০ম/.test( className );
			}

			syncProgram();
		}

		function syncProgram() {
			var item = currentProgram();

			paintModes( modeBox, item ? item.modes : [], modeBox ? ( modeBox.dataset.current || '' ) : '' );
			paintSummary( summary, item ? item.label : '', item ? item.fee : 0 );
		}

		classSelect.addEventListener( 'change', syncPrograms );

		if ( programSelect ) {
			programSelect.addEventListener( 'change', syncProgram );
		}

		if ( modeBox ) {
			modeBox.addEventListener( 'change', function ( event ) {
				if ( 'radio' === event.target.type ) {
					modeBox.dataset.current = event.target.value;
				}
			} );
		}

		syncPrograms();
	}

	function ccMoney( value ) {
		var digits = ( '0000' + Math.round( parseFloat( value ) || 0 ) ).slice( -4 );
		var out = '';
		var bangla = [ '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯' ];

		digits.split( '' ).forEach( function ( digit ) {
			out += bangla[ parseInt( digit, 10 ) ];
		} );

		return '৳ ' + out.replace( /\B(?=(\d{3})+(?!\d))/g, ',' );
	}

	/* ---------------------------------------------------------------- *
	 * Bangla numerals in text that was rendered by PHP.
	 * ---------------------------------------------------------------- */
	function initNumeralHint() {
		qa( '[data-bn]' ).forEach( function ( node ) {
			node.textContent = ccMoney( node.getAttribute( 'data-bn' ) );
		} );
	}

	/* ---------------------------------------------------------------- *
	 * Disable a submit button once used so a double click cannot post twice.
	 * ---------------------------------------------------------------- */
	function initSubmitLock() {
		qa( 'form' ).forEach( function ( form ) {
			form.addEventListener( 'submit', function () {
				var button = q( 'button[type="submit"]', form );

				if ( ! button ) {
					return;
				}

				button.disabled = true;
				button.dataset.label = button.textContent;
				button.textContent = i18n.sending || button.textContent;
			} );
		} );
	}

	/* ---------------------------------------------------------------- *
	 * Mobile navigation toggle.
	 * ---------------------------------------------------------------- */
	function initNavToggle() {
		var button = q( '.nav-toggle' );
		var nav = q( '#cc-primary-nav' );

		if ( ! button || ! nav ) {
			return;
		}

		button.addEventListener( 'click', function () {
			var open = nav.classList.toggle( 'open' );

			button.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );

		/* Close the menu after choosing a destination. */
		nav.addEventListener( 'click', function ( event ) {
			if ( 'A' === event.target.tagName ) {
				nav.classList.remove( 'open' );
				button.setAttribute( 'aria-expanded', 'false' );
			}
		} );
	}

	/* ---------------------------------------------------------------- *
	 * Dark mode toggle stored in localStorage.
	 * ---------------------------------------------------------------- */
	function initThemeToggle() {
		var button = q( '[data-cc-theme-toggle]' );
		var body = document.body;

		if ( ! button || ! body ) {
			return;
		}

		var stored = window.localStorage ? window.localStorage.getItem( 'cc-theme' ) : null;

		if ( stored ) {
			body.classList.toggle( 'cc-dark', 'dark' === stored );
			body.classList.toggle( 'cc-light', 'light' === stored );
		}

		button.addEventListener( 'click', function () {
			var isDark = body.classList.contains( 'cc-dark' ) ||
				( ! body.classList.contains( 'cc-light' ) && window.matchMedia( '(prefers-color-scheme: dark)' ).matches );

			body.classList.toggle( 'cc-dark', ! isDark );
			body.classList.toggle( 'cc-light', isDark );

			if ( window.localStorage ) {
				window.localStorage.setItem( 'cc-theme', isDark ? 'light' : 'dark' );
			}
		} );
	}

	function init() {
		initAnchors();
		initTabs();
		initRegistration();
		initNumeralHint();
		initSubmitLock();
		initNavToggle();
		initThemeToggle();
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );