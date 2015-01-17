@section('title')
Setup
@endsection

@section('form-title')
<h2>SETUP</h2>
@endsection

@section('form-content')
<form action="{{ URL::base() }}/{{Config::get('admin::config.admin_url')}}setupsubmit" method='post' class='form-validate' id="login">
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
    <div class="name controls">
      <input type="text" name='server' placeholder="Server" class='input-block-level' data-rule-required="true" >
    </div>
  </div>
  <div class="control-group">
    <div class="name controls">
      <input type="text" name='dbname' placeholder="Database name" class='input-block-level' data-rule-required="true" >
    </div>
  </div>
  <div class="control-group">
    <div class="name controls">
      <input type="text" name='dbuser' placeholder="Database username" class='input-block-level' data-rule-required="true" >
    </div>
  </div>
  <div class="control-group">
    <div class="name controls">
      <input type="text" name='dbpass' placeholder="Database password" class='input-block-level' data-rule-required="false" >
    </div>
  </div>
  <div class="control-group">
    <div class="name controls">
      <input type="text" name='firstname' placeholder="Firstname" class='input-block-level' data-rule-required="true"  >
    </div>
  </div>
  <div class="control-group">
    <div class="name controls">
      <input type="text" name='lastname' placeholder="Lastname" class='input-block-level' data-rule-required="true" data-rule-lettersonly="true">
    </div>
  </div>
  <div class="control-group">
    <div class="email controls">
      <input type="text" name='email' placeholder="Email address" class='input-block-level' data-rule-required="true" data-rule-email="true">
    </div>
  </div>
  <div class="control-group">
    <div class="pw controls">
      <input type="password" id="password" name="password" placeholder="Password" class='input-block-level' data-rule-required="true">
    </div>
  </div>
  <div class="control-group">
    <div class="pw controls">
      <input type="password" name="password_confirmation" placeholder="Confirm Password" class='input-block-level' data-rule-equalTo="#password">
    </div>
  </div>
  <div class="submit">
    <input type="submit" value="Submit" class='btn btn-primary'>
  </div>
</form>


@endsection
