<div class="clearfix margin_top10"></div>

<div class="page_title2">
<div class="container">
@if(isset($title))
    <h1>{{$title}}</h1>
@endif  
<div class="pagenation">

<span class='st_sharethis_large' displayText='ShareThis'></span>
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_whatsapp_large' displayText='WhatsApp'></span>   
</div>
</div>
</div><!-- end page title --> 

<div class="clearfix"></div>
<div class="content_fullwidth less2">
    <div class="container">
   
        <div class="content_left">
 @if(isset($center))
    {{$center}}
@endif            
        </div>
        
        <div class="right_sidebar">
 @if(isset($sidebar))
    {{$sidebar}}
@endif             
        </div>        
    </div>
</div>

<div class="clearfix marb12"></div>
