<!-- Team Section Begins -->
<section id="team" class=" slant-angle">

	<div class="section-inner" style="padding:0;">

		<!-- Screenshot Carousel Begins -->
		<div class="container slider-container">
			<div class="row">
				<div class="col-xs-12 animated" data-animation="fadeInUp" data-animation-delay="500">
					<!-- Carousel Slider Container Begins -->
					<div id="team-slider" class="">
						<!-- Item Begins -->
                                                

@if(isset($team) && count($team) > 0)

@foreach ( $team as $key=> $val)                                                
						<div class="team-item">
							<!-- Img -->
                                                        @if (AristotlL\Helper::validate_meta($val->meta,'image'))
							<img src="{{ AristotlL\Helper::validate_meta($val->meta,'image') }}" width="370"  alt="" class="img-responsive" />
                                                        @endif
							<!-- Team Member Details -->
							<div class="team-content">
								<h3 class="name">{{ $val->title }}</h3>
								<h4 class="designation">{{ AristotlL\Helper::validate_meta($val->meta,'position') }}</h4>							
							</div>
						</div>
@endforeach

@endif
						<!-- Item  Ends -->
						
					</div>
					<!-- Carousel Slider Container Ends -->
				</div>
			</div>
		</div>
		<!-- Screenshot Carousel Ends -->
	</div>
	
</section>
<!-- Team Section Ends -->