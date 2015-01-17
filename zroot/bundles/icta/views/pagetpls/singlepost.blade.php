 @if (isset($data))
    <div class="blog_post">	
            <div class="blog_postcontent">
            <div class="image_frame">
                @if($data->image)
                <img src="{{ URL::base()}}/{{ $data->image }}" style="width:100%;" alt="" />
                @endif
            </div>
            <h3>{{ $data->title }}</h3>
                <ul class="post_meta_links">
                    <li>
                        <a href="#" class="date">
                            
                            {{ IctaL\Helper::blog_date_helper($data->created_at) }}
                        </a>
                    </li>
                </ul>
             <div class="clearfix"></div>
             <div class="margin_top1"></div>
            <p>
                {{ $data->content }}
            </p>
            </div>
        </div><!-- /# end post -->
 @endif          
 <div class="clearfix divider_line9 lessm"></div>

