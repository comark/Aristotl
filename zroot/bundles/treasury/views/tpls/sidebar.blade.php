@if(isset($widgets) && count($widgets) > 0)
@foreach($widgets as $widget_key=>$widget_val)
 {{ $widget_val }}
 
@endforeach
@endif 