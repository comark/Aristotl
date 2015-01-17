<!doctype html>
<html>
  
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <!-- Apple devices fullscreen -->
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <!-- Apple devices fullscreen -->
  <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  
  <title>{{ Config::get('admin::config.site_title') }} -{{ Section::yield_content('title') }}</title>
{{ Asset::container('first')->styles() }}
{{ Asset::styles() }}
{{ Asset::container('last')->styles() }}

<script type="text/javascript">var BASE = "{{ URL::base() }}";</script>

  
<link rel="shortcut icon" href="{{ URL::to('admin_assets/img/favicon.ico'); }}">
<link rel="apple-touch-icon-precomposed" href="{{  URL::to('admin_assets/img/apple-touch-icon-precomposed.png'); }}">
 </head>
 
    <body class="theme-darkblue">
      {{ Section::yield_content('top-hidden') }}
      <div id="navigation">
        <div class="container-fluid">
          <a href="{{ URL::base() }}" id="brand">{{ Config::get('admin::config.site_title') }}</a>
          <a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-reorder"></i></a>
          
          @section('navigation')
          <ul class='main-nav'>
            @yield_section
          </ul>
          <div class="user">
           {{ Section::yield_content('user') }}
          </div>
        </div>
      </div>
      <div class="container-fluid" id="content">
       
       @section('content-left')
        <div id="left">
          @yield_section
        </div>
        <div id="main">
         {{ Section::yield_content('content-main') }}
        </div>
      </div>
    <div id="footer">
      <p>
        {{ Config::get('admin::config.site_title') }} <span class="font-grey-4">|</span> <a href="#">Contact Admin</a> <span class="font-grey-4">|</span>
      </p>
      <a href="#" class="gototop"><i class="icon-arrow-up"></i></a>
    </div>
{{ Asset::container('first')->scripts() }}
{{ Asset::scripts() }}
{{ Asset::container('last')->scripts() }}
    </body>
</html>