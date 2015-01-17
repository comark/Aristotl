@section('title')
Sign in
@endsection

@section('form-title')
<h2>SIGN IN</h2>
@endsection

@section('form-content')
<form action="{{ URL::base() }}/{{Config::get('admin::config.admin_url')}}xauthenticate" method='post' class='form-validate' id="login">
@if (Session::get('notes') )
  <div class="control-group error">
    <div class="controls">
     <span class="help-block error" style="">{{ Session::get('notes') }}</span>
    </div>
  </div>
@endif
@if (Session::get('myerrors') )
  <div class="control-group error">
    <div class="controls">
     <span class="help-block error" style="">{{Session::get('myerrors') }}</span>
    </div>
  </div>
@endif
@if ( count($errors->messages) > 0 )
  <div class="control-group error">
    <div class="controls">
    @foreach ( $errors->messages as $key => $val)  
    <span class="help-block error" style="">{{ $val[0]}}</span>
    @endforeach
    </div>
  </div>
@endif

  <div class="control-group">
    <div class="email controls">
      <input type="text" name='email' placeholder="Email address" class='input-block-level' data-rule-required="true" data-rule-email="true">
    </div>
  </div>
  <div class="control-group">
    <div class="pw controls">
      <input type="password" name="password" placeholder="Password" class='input-block-level' data-rule-required="true">
    </div>
  </div>
  <div class="submit">
    <div class="remember">
      <input type="checkbox" name="remember" class='icheck-me' data-skin="square" data-color="blue" id="remember">       <label for="remember">Remember me</label>
    </div>
    @if ( isset($redirect)) 
      <input type="hidden" name="redirect" value="{{ $redirect }}">
    @endif
    <input type="submit" value="Sign me in" class='btn btn-primary'>
  </div>
</form>
<div class="forget">
  <a href="{{ URL::base() }}/{{Config::get('admin::config.admin_url')}}xforgotpassword"><span>Forgot password?</span></a>
</div>

@endsection
