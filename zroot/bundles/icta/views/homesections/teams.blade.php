
<div class="features_sec9">
<div class="container">
	
    <div class="title2">
    	<h2><span class="line"></span><span class="text">Meet Our Team</span></h2>
    </div>
    
    <div class="clearfix margin_top3"></div>

@if(isset($team) && count($team) > 0)

@foreach ( $team as $key=> $val)
    <div class="one_fourth animate" data-anim-type="fadeInLeft" data-anim-delay="300">
    
    	<div class="tbox">
            @if (IctaL\Helper::validate_meta($val->meta,'image'))
        	<img width="257" src="{{ IctaL\Helper::validate_meta($val->meta,'image') }}" alt="" />  
            @endif
            <h6>{{ $val->title }}</h6>
			<em>{{ IctaL\Helper::validate_meta($val->meta,'position') }} </em>           
        </div>
        
    </div><!-- end section -->
@endforeach
@endif
    

    
</div>
</div><!-- end features section 9 -->

<div class="clearfix"></div>
