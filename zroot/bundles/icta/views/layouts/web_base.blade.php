<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en-gb" class="no-js"> <!--<![endif]-->

<head>
    
   {{ Section::yield_content('title') }}

  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
  {{ Asset::container('first')->styles() }}
  {{ Asset::container('middle')->styles() }}
  {{ Asset::styles() }}
  {{ Asset::container('last')->styles() }}
  
  
  <link rel="shortcut icon" href="<?php echo URL::to('icta/images/favicon.ico') ?>">
<script type="text/javascript">var BASE = "{{ URL::base() }}";</script>
  {{ Asset::container('first')->scripts() }}  

</head>  

<body>
    <div class="site_wrapper">
        
        <header class="header">
          {{  Section::yield_content('header') }}
        </header>      
        <div class="clearfix"></div>
        {{ Section::yield_content('content') }}
        <div class="clearfix"></div>
        
        <footer class="footer">
          {{ Section::yield_content('footer') }}
        </footer>
        
        <a href="#" class="scrollup">Scroll</a><!-- end scroll to top of the page-->
    </div>    
  

  {{ Asset::container('middle')->scripts() }}
  {{ Asset::scripts() }}
  {{ Asset::container('last')->scripts() }}
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->  
<script type="text/javascript">
(function($) {
 "use strict";

	var slider = new MasterSlider();
	// adds Arrows navigation control to the slider.
	slider.control('arrows');
	slider.control('bullets');

	 slider.setup('masterslider' , {
		 width:1400,    // slider standard width
		 height:750,   // slider standard height
		 space:0,
		 speed:45,
		 layout:'fullwidth',
		 loop:true,
		 preload:0,
		 autoplay:true,
		 view:"fade"
	});
	
	var slider2 = new MasterSlider();

	 slider2.setup('masterslider2' , {
		 width:1400,    // slider standard width
		 height:520,   // slider standard height
		 space:0,
		 speed:45,
		 layout:'fullwidth',
		 loop:true,
		 preload:0,
		 autoplay:true,
		 view:"basic"
	});
	
})(jQuery);
</script>

<script type="text/javascript">
(function($) {
 "use strict";
 
	$(document).ready(function() {
		$(".main-slider-container").sliderbac();
	});
	
})(jQuery);
</script>
</body>
</html>