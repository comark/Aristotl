 @if (isset($data))
    <div class="blog_post">	
            <div class="blog_postcontent">

            <h3>{{ $data->title }}</h3>
                <ul class="post_meta_links">
                    <li>
                        <a href="#" class="date">                            
                            {{ AristotlL\ContentHelper::blog_date_helper($data->created_at) }}
                        </a>
                    </li>
                </ul>
            <div class="image_frame">
                @if(AristotlL\ContentHelper::custom_meta_object('image',$data->meta))
                <img src="{{ URL::base()}}/{{ AristotlL\ContentHelper::custom_meta_object('image',$data->meta) }}" style="width:100%;" alt="" />
                @endif
            </div>
             <div class="clearfix"></div>
             <div class="margin_top1"></div>
            <p>
                {{ AristotlL\ContentHelper::custom_meta_object('long_description',$data->meta) }}
            </p>
            </div>
        </div><!-- /# end post -->
 @endif          
 <div class="clearfix divider_line9 lessm"></div>

