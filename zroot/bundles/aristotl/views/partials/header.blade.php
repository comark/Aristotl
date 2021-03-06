<!-- Header Top section -->
<div class="header-top">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Top Navbar Begins -->
				<div  class="navbar ">
					<!-- Mail and Phone Number -->
					<div class="navbar-header">
						<ul class="header-top-left">
							<li> <a href="mailto:user@aristotl.co.ke"> <i class="flaticon-black164"></i>user@aristotl.co.ke </a> </li>
							<li> <a href="#"> <i class="flaticon-phone46"></i> +254 020 2252299 </a> </li>
						</ul>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <i class="flaticon-list50"></i> </button>
					</div>
					<!-- Social Icons -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right header-top-right">
							<li><a href="#"><i class="flaticon-facebook55 facebook-icon"></i></a></li>
							<li><a href="#"><i class="flaticon-twitter20 twitter-icon"></i></a></li>
						</ul>
					</div>
				</div>
				<!-- Top Navbar Ends -->
			</div>
		</div>
	</div>
</div>

<!-- Header Begins -->
<div id="sticky-section" class="sticky-navigation">
	<nav class="navbar navbar-default menu-bar" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Logo and toggle get grouped for better mobile display -->
					<div class="navbar-header col-md-4" >
                                            <div class="site-logo"> <a title="Logo" href="#"><img width="100%;" src="{{ URL::base() }}/aristotl/assets/toplogo.png"></a> </div>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2"> <span class="menu-box"><span class="menu">Menu</span><i class="flaticon-list50 menu-button"></i></span> </button>
					</div>
					<!-- Collect the nav links, buttons and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2" style="">
                                            
@if (isset($content['menu']) )
  {{ $content['menu'] }}
@endif
                                                
					
					</div>
					<!-- /.navbar-collapse -->
				</div>
			</div>
		</div>
		<!-- /.container -->
	</nav>
	<!-- Header Ends -->
</div>





            