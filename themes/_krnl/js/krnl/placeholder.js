/**
 *		krnl js module:
 *			placeholder.js
 *
 *		desc:
 *			Placeholder module.
 *
 *		requires:
 *			jQuery
 */

var krnl = ( function( app, $ ) {

	/* define new module */
	app.placeholder = ( function( $ ) {

		// private vars

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		function _init() {			
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


		/* return public-facing methods and/or vars */
		return {
			init : _init
		};
		
	}($));
	
	return app; /* return augmented app object */
	
}( krnl || {}, jQuery ) ); /* import app if exists, or create new; import jQuery */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// register this module for initialization
// krnl.bootstrap.register( krnl.placeholder.init );