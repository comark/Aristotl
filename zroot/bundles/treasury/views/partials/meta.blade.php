    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

  @if (isset ($title))
  <title>{{ Config::get('treasury::config.site_title') }} - {{ $title }}</title>
  @else
  <title>{{ Config::get('treasury::config.site_title') }}</title>
  @endif

