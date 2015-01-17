 @if (isset($data))

        
			<!-- Blog Photo-->
                        <div class="blog-post">
			<div class="blog-top animated" data-animation="fadeInUp" data-animation-delay="500">
                @if(TreasuryL\ContentHelper::custom_meta_object('image',$data->meta))
                <img src="{{ URL::base()}}/{{ TreasuryL\ContentHelper::custom_meta_object('image',$data->meta) }}" alt="blog-photo" class="img-responsive blog-photo" />
                @endif                            
				
				
			</div>	
			<!-- Blog Post-Description-->
			<div class="col-md-12 animated" data-animation="fadeInUp" data-animation-delay="500">	
				<div class="thumbnail">	
					<div class="caption">
						<h3>{{ $data->title }}</h3>
						
						<p class="blog-content">  {{TreasuryL\ContentHelper::custom_meta_object('content',$data->meta)}} </p>
                @if ( TreasuryL\ContentHelper::custom_meta_object('file',$data->meta) )
                <a href="{{URL::base()}}/{{TreasuryL\ContentHelper::custom_meta_object('file',$data->meta)}}" class="date">                            
                   Download
                </a>
                @endif			
					</div>
				</div>
			</div>   
                        </div>
 @endif          
