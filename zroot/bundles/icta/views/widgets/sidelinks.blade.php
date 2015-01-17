	<div class="sidebar_widget">
    	<div class="sidebar_title"><h4>Quick Links</h4></div>
		<ul class="arrows_list1">
                    
            @foreach (IctaL\Helper::sidebarmenu_helper() as $key=>$val)
                <li><a href="{{ URL::base() }}/{{ $val['url']}}"><i class="fa fa-angle-right"></i> {{ $val['title']}} </a></li>
            @endforeach

		</ul>
	</div><!-- end section -->
    
    <div class="clearfix margin_top4"></div>