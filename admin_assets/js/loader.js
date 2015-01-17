/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready( function() {
    jQuery('<div class="loader"></div>').css( {
    display:    'none',
    position:   'fixed',
    'z-index':  1000,
    top:        0,
    left:       0,
    height:     '100%',
    width:      '100%',
    'background-color': 'rgba( 255, 255, 255, .8 )',
    'background-image': 'url('+ BASE +'/admin_assets/img/loading.gif)',
    'background-position': '50% 50%',
    'background-repeat': 'no-repeat',
  }).appendTo("body");

   var html = 
	['<div id="modal-notification" class="modal hide">',
		'<div class="modal-header">',
			'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
			'<h3 id="modal-title"></h3>',
		'</div>',
		'<div class="modal-body" id="modal-body">',
			'<div class="row-fluid">',
				'<div class="span12" id="modal-text"></div>',
			'</div>',
		'</div>',
		'<div class="modal-footer">',
			'<button class="btn modal-close-btn" data-dismiss="modal">Close</button>',
		'</div>',
	'</div>'
  ].join('\n'); 

  jQuery(html).appendTo('body');
});
