<!-- 
Template Name: Blog List
--> 

@if (IctaL\Helper::get_blogs())

@foreach ( IctaL\Helper::get_blogs() as $data )
    <div class="blog_post">	
            <div class="blog_postcontent">
            <h3><a href="{{ URL::base() }}/blogitem/{{ $data->guid }}">{{ $data->title }}</a></h3>
                        
                <ul class="post_meta_links">
                    <li>
                        <a href="#" class="date">                            
                            {{ IctaL\Helper::blog_date_helper($data->created_at) }}
                        </a>
                    </li>
                </ul>
            <div class="image_frame">
                @if($data->image)
                <img src="{{ URL::base()}}/blogitem/{{ $data->image }}" style="width:100%;" alt="" />
                @endif
            </div>
            <p>
                {{ $data->content }}
            </p>
             <div class="clearfix"></div>
             <div class="margin_top1"></div>
        
            </div>
        </div><!-- /# end post -->
         <div class="clearfix divider_line9 lessm"></div>
 @endforeach
 @endif          


