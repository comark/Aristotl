@if ( isset($msg) )
<div class="row-fluid">
  <div class="span12">
     @if ( isset($msg['class']))
      <div class="alert alert-{{ $msg['class'] }}">
     @else
       <div class="alert">
     @endif
     
       <button type="button" class="close" data-dismiss="alert">&times;</button>
     
     @if ( isset($msg['class']) && $msg['class'] == 'success')
        <strong>Success!</strong>
     @elseif ( isset($msg['class']) && $msg['class'] == 'info')
        <strong>Note!</strong>
     @elseif ( isset($msg['class']) && $msg['class'] == 'error')
        <strong>Error!</strong>
     @endif
     
     @if ( isset($msg['msg']) )
       {{ $msg['msg']}}
     @endif
      </div>
  </div>
</div>
@endif
