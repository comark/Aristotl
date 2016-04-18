<!-- 
Template Name: Public Sector List
--> 

@if (AristotlL\ContentHelper::get_custom('publicsector'))

    @foreach ( AristotlL\ContentHelper::get_custom('publicsector') as $data_big_key=>$data_big_val )
        @if(isset($data_big_val) && $data_big_key == 'pagination_top')
               {{ $data_big_val }}
        @endif
        
        @if(isset($data_big_val) && $data_big_key == 'data')
            @foreach( $data_big_val as $data)
              {{ AristotlL\ContentHelper::single_custom('publicsector',$data) }}
            @endforeach
        @endif

        @if(isset($data_big_val) && $data_big_key == 'pagination_bottom')
               {{ $data_big_val }}
        @endif
    @endforeach
@endif          
      


