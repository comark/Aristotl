@section('title')
Notifications
@endsection

@section('form-title')
<h2>Notifications</h2>
@endsection

@section('form-content')
<p style="padding-top:20px; padding-left: 30px; padding-bottom: 5px; padding-right: 30px; ">{{ Session::get('notifications') }} </p>
@endsection
