@if (isset($sects) && count($sects) > 0 )
   <div class="row-fluid">
       <div class="span6">           
         @foreach ( $sects as $sect_key => $sect_val)
           {{ $sect_val }}
       </div>
          @if ($sect_key % 2 == 1 ) 
   </div>
   <div class="row-fluid">
          @endif
       <div class="span6">
         @endforeach
       </div>
  </div>        
@endif
