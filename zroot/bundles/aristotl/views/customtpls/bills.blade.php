<!-- 
Template Name: Bills List
--> 

@if (AristotlL\ContentHelper::get_custom('bills'))

    @foreach ( AristotlL\ContentHelper::get_custom('bills') as $data_big_key=>$data_big_val )
        @if(isset($data_big_val) && $data_big_key == 'pagination_top')
               {{ $data_big_val }}
        @endif
        
        @if(isset($data_big_val) && $data_big_key == 'data')
            @foreach( $data_big_val as $data)
              {{ AristotlL\ContentHelper::single_custom('bills',$data) }}
            @endforeach
        @endif

        @if(isset($data_big_val) && $data_big_key == 'pagination_bottom')
               {{ $data_big_val }}
        @endif
    @endforeach
@endif          
      


