
<!-- Page Descrription Begins-->
<div class="page-desc-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 page-desc">
@if(isset($title))
<h2 class="animated"  data-animation="fadeInRight" data-animation-delay="300">{{$title}}</h2>
<p class="animated"  data-animation="fadeInLeft" data-animation-delay="300"></p>
@endif                             

			</div>
		</div>
	</div>
</div>
<!-- Page Description Ends-->


<div class="container">
	<div class="row">
            <div class="col-md-9 col-sm-9">
 @if(isset($center))
    {{$center}}
@endif            
            </div>
        
        
            <div class="col-md-3 col-sm-3 side-bar"> 
 @if(isset($sidebar))
    {{$sidebar}}
@endif             
            </div>  
    </div>            
</div>


