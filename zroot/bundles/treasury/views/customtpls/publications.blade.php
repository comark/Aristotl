<!-- 
Template Name: Publications List
--> 

@if (TreasuryL\ContentHelper::get_custom('publications'))

    @foreach ( TreasuryL\ContentHelper::get_custom('publications') as $data_big_key=>$data_big_val )
        @if(isset($data_big_val) && $data_big_key == 'pagination_top')
               {{ $data_big_val }}
        @endif
        
        @if(isset($data_big_val) && $data_big_key == 'data')
            @foreach( $data_big_val as $data)
              {{ TreasuryL\ContentHelper::single_custom('publications',$data) }}
            @endforeach
        @endif

        @if(isset($data_big_val) && $data_big_key == 'pagination_bottom')
               {{ $data_big_val }}
        @endif
    @endforeach
@endif          
      


