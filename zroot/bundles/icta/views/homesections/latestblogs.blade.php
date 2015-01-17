

<div class="features_sec4">
    <div class="container">

        <div class="onecol_sixty">

            <h3 class="unline"><i class="fa fa-comments"></i> Latest Posts</h3>

            <div class="clearfix"></div>

@if(isset($latest) && count($latest>0))
  @foreach ($latest as $lt)
            <div class="lblogs animate" data-anim-type="fadeIn" data-anim-delay="300">

                
                <div class="lbimg">
                    @if ( $lt->image )
                    <img width="280" src="{{ $lt->image }}" alt="" />
                    @endif
                    {{ IctaL\Helper::home_date_helper($lt->created_at) }}
                    
                </div>

                <h5>{{ $lt->title }}</h5>

                <p>{{ IctaL\Helper::home_blog_snippet($lt->content) }}</p>

                <a href="{{ URL::base() }}/blogitem/{{ $lt->guid }}" class="remobut">Read More</a>

            </div><!-- end section -->
  @endforeach
@endif

 

        </div><!-- end all sections -->

        <div class="onecol_forty last">

            <div class="peosays">

                <h3 class="unline"><i class="fa fa-briefcase"></i> Projects</h3>

                <div class="clearfix"></div>

                <div id="owl-demo11" class="owl-carousel small four">
                    
@if (isset($projects) && count($projects) > 0 )                    

@foreach ($projects as $key=>$val)
                    <div class="box">

                        <div class="ppimg">
                            @if (IctaL\Helper::validate_meta($val->meta,'image'))
                            <img src="{{ IctaL\Helper::validate_meta($val->meta,'image') }}" style="width:80px; height:auto; border-radius:1%;" alt="" /> 
                            @endif
                            <h6>{{ $val->title }} </h6>
                        </div>
@if (IctaL\Helper::validate_meta($val->meta,'image'))
                        <p>{{ IctaL\Helper::validate_meta($val->meta,'short_description') }}</p>
@endif                       
                       

                    </div><!-- end slide -->
@endforeach
@endif





                </div>

            </div>

        </div>

    </div>
</div><!-- end features section 4 -->

<div class="clearfix"></div>
