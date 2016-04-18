		<div class="container" style="margin-bottom:20px;">
			<!-- Items -->
			<div class="row">
				<!-- Item 1 -->
				<div class="col-sm-3 front" data-animation="fadeInUp" data-animation-delay="300">
					<!-- Title -->
					<h3>Bills</h3>
					<ul style="list-style:none;">
						{{ AristotlL\ContentHelper::display_front_custom('bills') }}
					</ul>
					<a href="{{ URL::base() }}/pages/bills">Read more</a>
				</div>
				<!-- Item 2 -->
				<div class="col-sm-3 front" data-animation="fadeInUp" data-animation-delay="700">
					<!-- Title -->
					<h3>Reports</h3>
					<ul style="list-style:none;">
						{{ AristotlL\ContentHelper::display_front_custom('reports') }}
					</ul>
					<a href="{{ URL::base() }}/pages/reports">Read more</a>
				</div>
				<!-- Item 3 -->
				<div class="col-sm-3 front" data-animation="fadeInUp" data-animation-delay="700">
					<!-- Title -->
					<h3>Publications</h3>
					<ul style="list-style:none;">
						{{ AristotlL\ContentHelper::display_front_custom('publications') }}
					</ul>
					<a href="{{ URL::base() }}/pages/publications">Read more</a>
				</div>
				<!-- Item 4 -->
				<div class="col-sm-3 front" data-animation="fadeInUp" data-animation-delay="900">
					<!-- Title -->
					<h3>News</h3>
					<ul style="list-style:none;">
						{{ AristotlL\ContentHelper::display_news_custom() }}
					</ul>
					<a href="{{ URL::base() }}/pages/news">Read more</a>
				</div>
			</div>
		</div>
