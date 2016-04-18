<!-- 
Template Name: Regulations List
--> 

@if (EnergyL\ContentHelper::get_custom('regulations'))

    @foreach ( EnergyL\ContentHelper::get_custom('regulations') as $data_big_key=>$data_big_val )
        @if(isset($data_big_val) && $data_big_key == 'pagination_top')
               {{ $data_big_val }}
        @endif
        
        @if(isset($data_big_val) && $data_big_key == 'data')
            @foreach( $data_big_val as $data)
              {{ EnergyL\ContentHelper::single_custom('regulations',$data) }}
            @endforeach
        @endif

        @if(isset($data_big_val) && $data_big_key == 'pagination_bottom')
               {{ $data_big_val }}
        @endif
    @endforeach
@endif          
      


