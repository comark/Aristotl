<!-- 
Template Name: Blog List
--> 

@if (AristotlL\ContentHelper::get_blogs('post'))

@foreach ( AristotlL\ContentHelper::get_blogs('post') as $data_big_key=>$data_big_val )

        @if(isset($data_big_val) && $data_big_key == 'pagination_top')
               {{ $data_big_val }}
        @endif
        
        @if(isset($data_big_val) && $data_big_key == 'data')
            @foreach( $data_big_val as $data)
               {{ AristotlL\ContentHelper::single_blog($data) }}
            @endforeach
        @endif

        @if(isset($data_big_val) && $data_big_key == 'pagination_bottom')
               {{ $data_big_val }}
        @endif
   

 @endforeach
 @endif          


