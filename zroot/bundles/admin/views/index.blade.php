@layout('admin::layouts/admin_base')

@section('title')
 @if (isset ($page_title))
   {{ $page_title }}
 @endif
@endsection

@section('top-hidden')
  @if( isset($top_hidden) )
  {{ $top_hidden }}
  @endif
@endsection

@section('navigation')
@parent
  @if ( isset($nav) )
  {{ $nav }}
  @endif
@endsection


@section('user')
  @if ( isset($user_messages) )
  {{ $user_messages }}
  @endif
  @if ( isset($user) )
  {{ $user }}
  @endif
@endsection
@section('content-left')
@parent 
  @if ( isset($left_admin) )
   {{ $left_admin }}
  @endif
  @if ( isset($left_hook) )
   {{ $left_hook }}
  @endif
@endsection

@section('content-main')
<div class="container-fluid">
  @if (isset($center_top))
    {{ $center_top }}
  @endif
  @if (isset ($no_access))
     {{ $no_access }}
  @else
    @if ( isset($notes) )
     {{  $notes }}
    @endif
    @if (isset($main))
     {{ $main }}
    @endif
  @endif
</div>
@endsection
