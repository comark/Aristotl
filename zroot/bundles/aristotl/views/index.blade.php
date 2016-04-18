@layout('aristotl::layouts/web_base')

@section('title')
 @if (isset ($page_title))
   {{ $page_title }}
 @endif
@endsection

@section('header')
  @if( isset($section_header) )
  {{ $section_header }}
  @endif
@endsection

@section('carousel')
  @if( isset($section_carousel) )
  {{ $section_carousel }}
  @endif
@endsection

@section('content')
  @if( isset($notify_content) )
  {{ $notify_content }}
  @endif
  @if( isset($section_content) )
  {{ $section_content }}
  @endif 
@endsection

@section('footer')
  @if( isset($section_footer) )
  {{ $section_footer }}
  @endif
@endsection