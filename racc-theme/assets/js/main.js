/* RACC theme interactions: sticky header, mobile menu, scroll reveal, project filter, active nav link. */
( function () {
	'use strict';

	document.documentElement.classList.add( 'js' );

	var header = document.querySelector( '[data-header]' );
	var toggle = document.querySelector( '[data-nav-toggle]' );
	var nav = document.querySelector( '[data-nav]' );

	// Sticky header style once the page scrolls.
	function onScroll() {
		if ( header ) {
			header.classList.toggle( 'is-scrolled', window.scrollY > 40 );
		}
	}
	onScroll();
	window.addEventListener( 'scroll', onScroll, { passive: true } );

	// Mobile menu.
	function setMenu( open ) {
		if ( ! toggle || ! nav ) {
			return;
		}
		toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		nav.classList.toggle( 'is-open', open );
		document.body.classList.toggle( 'nav-open', open );
	}
	if ( toggle && nav ) {
		toggle.addEventListener( 'click', function () {
			setMenu( toggle.getAttribute( 'aria-expanded' ) !== 'true' );
		} );
		nav.addEventListener( 'click', function ( e ) {
			if ( e.target.closest( 'a' ) ) {
				setMenu( false );
			}
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' ) {
				setMenu( false );
			}
		} );
	}

	// Reveal on scroll.
	var reveals = document.querySelectorAll( '.reveal' );
	if ( 'IntersectionObserver' in window ) {
		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-visible' );
					io.unobserve( entry.target );
				}
			} );
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 } );
		reveals.forEach( function ( el, i ) {
			el.style.transitionDelay = ( i % 3 ) * 80 + 'ms';
			io.observe( el );
		} );
	} else {
		reveals.forEach( function ( el ) {
			el.classList.add( 'is-visible' );
		} );
	}

	// Project filter.
	var filters = document.querySelector( '[data-filters]' );
	var grid = document.querySelector( '[data-projects]' );
	if ( filters && grid ) {
		filters.addEventListener( 'click', function ( e ) {
			var btn = e.target.closest( '[data-filter]' );
			if ( ! btn ) {
				return;
			}
			var key = btn.getAttribute( 'data-filter' );
			filters.querySelectorAll( '[data-filter]' ).forEach( function ( b ) {
				var on = b === btn;
				b.classList.toggle( 'is-active', on );
				b.setAttribute( 'aria-pressed', on ? 'true' : 'false' );
			} );
			grid.querySelectorAll( '[data-sector]' ).forEach( function ( card ) {
				var show = key === '*' || card.getAttribute( 'data-sector' ) === key;
				card.classList.toggle( 'is-hidden', ! show );
				if ( show ) {
					card.classList.add( 'is-visible' );
				}
			} );
		} );
	}

	// Highlight the nav link for the section in view.
	var links = document.querySelectorAll( '.nav-list a[href*="#"]' );
	if ( links.length && 'IntersectionObserver' in window ) {
		var map = {};
		links.forEach( function ( a ) {
			var id = a.getAttribute( 'href' ).split( '#' )[ 1 ];
			var section = id && document.getElementById( id );
			if ( section ) {
				map[ id ] = a;
			}
		} );
		var spy = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				var link = map[ entry.target.id ];
				if ( link && entry.isIntersecting ) {
					links.forEach( function ( l ) {
						l.classList.remove( 'is-active' );
					} );
					link.classList.add( 'is-active' );
				}
			} );
		}, { rootMargin: '-45% 0px -50% 0px' } );
		Object.keys( map ).forEach( function ( id ) {
			spy.observe( document.getElementById( id ) );
		} );
	}
}() );
