<!-- Top Slider Begins -->
<section class="top-slider">
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->

		<!-- Wrapper for slides -->
		<div class="container">
			<div class="carousel-inner">
    @if (TreasuryL\ContentHelper::slider_helper() )
      @foreach( TreasuryL\ContentHelper::slider_helper() as $skey=>$slide )
     
                    @if($skey == 1)
                        <div class="item active">
                    @else
                        <div class="item">
                    @endif
                  
				
					<div class="row">
						<div class="carousel-caption" style="width:300px;">
                                                    @if(isset($slide['title']))
							<h1>{{ $slide['title'] }}</h1>
                                                   @endif
                                                   
                                                   @if(isset($slide['description']))
							<p>{{ $slide['description'] }}</p>
                                                   @endif
						</div>
						<div class="col-md-8 col-md-offset-4"> <img src="{{URL::base()}}/{{ $slide['image'] }}" class="img-responsive"  alt="slider-1"> </div>
					</div>
				</div>
      @endforeach
    @endif
                        </div>
		</div>
	</div>
	<!-- Controls -->
	<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <i class="fa fa-angle-left"></i> </a> <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> <i class="fa fa-angle-right"></i> </a> </section>
<!-- Top Slider Ends -->