<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en-gb" class="no-js"> <!--<![endif]-->

<head>
    
   {{ Section::yield_content('title') }}

  <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  {{ Asset::container('first')->styles() }}
  {{ Asset::container('middle')->styles() }}
  {{ Asset::styles() }}
  {{ Asset::container('last')->styles() }}
  
  
  <link rel="shortcut icon" href="<?php echo URL::to('treasury/images/favicon.ico') ?>">
<script type="text/javascript">var BASE = "{{ URL::base() }}";</script>
  {{ Asset::container('first')->scripts() }}  

</head>  

<body>
<!-- Page Loader -->
<div id="pageloader">
	<div class="loader-item fa fa-spin colored-border"></div>
</div>    

  
      {{  Section::yield_content('header') }}
       
      {{ Section::yield_content('content') }}

      {{ Section::yield_content('footer') }}

        
  
  

  {{ Asset::container('middle')->scripts() }}
  {{ Asset::scripts() }}
  {{ Asset::container('last')->scripts() }}

</body>
</html>