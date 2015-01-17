<!doctype html>
<html>
  
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <!-- Apple devices fullscreen -->
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <!-- Apple devices fullscreen -->
  <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  
  <title>{{ Config::get('admin::config.site_title') }} - {{ Section::yield_content('title') }}</title>
{{ Asset::container('first')->styles() }}
{{ Asset::styles() }}
{{ Asset::container('last')->styles() }}


<script type="text/javascript">var BASE = "{{ URL::base() }}";</script>


  <link rel="shortcut icon" href="{{ URL::base() }}/admin_assets/img/favicon.ico">
  <link rel="apple-touch-icon-precomposed" href="{{ URL::base() }}/admin_assets/img/apple-touch-icon-precomposed.png">
    </head>
 
    <body class="login theme-darkblue">
      <div class="wrapper">
          <div class="login-logo" style="background: #fff;">

          </div>
        <div class="login-body">
          {{ Section::yield_content('form-title') }}
          {{ Section::yield_content('form-content') }}
        </div>
      </div>
    </body>
{{ Asset::container('first')->scripts() }}
{{ Asset::scripts() }}
{{ Asset::container('last')->scripts() }}
</html>