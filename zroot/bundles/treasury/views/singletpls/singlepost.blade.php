 @if (isset($data))

        
			<!-- Blog Photo-->
                        <div class="blog-post">
			<div class="blog-top animated" data-animation="fadeInUp" data-animation-delay="500">
                @if($data->image)
                <img src="{{ URL::base()}}/{{ $data->image }}" alt="blog-photo" class="img-responsive blog-photo" />
                @endif                            
				
				<!-- Blog Post-Date-->
				<div class="blog-date">
					{{ TreasuryL\ContentHelper::blog_date_helper($data->created_at) }}
				</div>
			</div>	
			<!-- Blog Post-Description-->
			<div class="col-md-12 animated" data-animation="fadeInUp" data-animation-delay="500">	
				<div class="thumbnail">	
					<div class="caption">
						<h3>{{ $data->title }}</h3>
						
						<p class="blog-content"> {{ $data->content }}</p>
			
					</div>
				</div>
			</div>   
                        </div>
 @endif          
 <div class="clearfix divider_line9 lessm"></div>

