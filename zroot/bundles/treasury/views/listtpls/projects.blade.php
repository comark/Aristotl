
<div class="blog_post">	
    <div class="blog_postcontent">
        <h3><a href="{{ ICTAL\ContentHelper::custom_url_helper($data)}}">{{ $data->title }}</a></h3>


        <div class="image_frame">
                {{ ICTAL\ContentHelper::custom_meta_object('short_description',$data->meta)}}
        </div>
        <ul class="post_meta_links">
            <li>
                <a href="{{ ICTAL\ContentHelper::custom_url_helper($data)}}" class="date">                            
                   Read more
                </a>
            </li>
        </ul>
        <div class="clearfix"></div>
        <div class="margin_top1"></div>

    </div>
</div><!-- /# end post -->
<div class="clearfix divider_line9 lessm"></div>