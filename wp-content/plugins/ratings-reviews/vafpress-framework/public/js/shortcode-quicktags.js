(function($){
	"use strict";

	if( typeof QTags !== 'undefined' )
	{
		var qt_cb = function(name){
			return function(){
				tinyMCE.execCommand(name + '_cmd');
			}
		}
		for (var i = 0; i < w2rr_vp_sg.length; i++) {
			QTags.addButton( w2rr_vp_sg[i].name, 'Vafpress', qt_cb(w2rr_vp_sg[i].name), '', '', w2rr_vp_sg[i].button_title, 999999 );
		}
	}

})(jQuery);