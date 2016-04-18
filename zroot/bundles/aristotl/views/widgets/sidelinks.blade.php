                    <div class="panel panel-default animated" data-animation="fadeInUp" data-animation-delay="300">
                            <div class="panel-heading">
                            <h3>Quick Links</h3>
                            </div>
                            <div class="panel-body">
                                <ul>
            @foreach (AristotlL\Helper::sidebarmenu_helper() as $key=>$val)
                <li><a href="{{ URL::base() }}/{{ $val['url']}}"><i class="fa fa-angle-right"></i> {{ $val['title']}} </a></li>
            @endforeach                                    
                                </ul>
                            </div>
                    </div>
