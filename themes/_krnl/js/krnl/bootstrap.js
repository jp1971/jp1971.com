/**
 * 		krnl js module:
 * 			bootstrap.js
 *
 *		desc:
 * 			Controls the basics of initializing krnl site js code.
 * 			Various modules register their initialization needs with this
 * 			module. Once the document is ready, this module is activated,
 * 			initializing various site sub-modules.
 * 		
 * 		requires:
 * 			jQuery
 */

var krnl = (function( app ) {
	
	/* define new module */
	app.bootstrap = (function(){
		
		// vars
		var _init_callbacks = [];
			
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
		
		function _init() {
			
			for (var i=0; i < _init_callbacks.length; i++) {
				_init_callbacks[i]();
			};
			
		}
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
		
		function _register( callback ) {
			
			_init_callbacks.push( callback );
			
		}
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
		
		function _docwrite(options) {
			
			_register(function(){
				$(options.selector).html(options.json);
			});
			
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
		
		/* return public-facing methods and/or vars */
		return {
			init : _init
			,register : _register
			,docwrite : _docwrite
		};
		
	}());
	
	return app; /* return augmented app object */
	
}( krnl || {} )); /* import app if exists, or create new */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */