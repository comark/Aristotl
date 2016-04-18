@if(isset($data['image']) && $data['image'] != '')
<img style="max-width: 100%;" src="{{ $data['image'] }}" />
@endif
<br/>
@if(isset($data['content']))
{{ $data['content'] }}
@endif
