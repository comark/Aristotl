

 	<!-- Navigation Menu -->
	<nav class="menu_main">
        
	<div class="navbar yamm navbar-default">
    
    <div class="container">
      <div class="navbar-header">
        <div class="navbar-toggle .navbar-collapse .pull-right " data-toggle="collapse" data-target="#navbar-collapse-1"  > <span>Menu</span>
          <button type="button" > <i class="fa fa-bars"></i></button>
        </div>
      </div>
      
      <div id="navbar-collapse-1" class="navbar-collapse collapse pull-right">
      
        <ul class="nav navbar-nav">
            @if (isset($menu) && count($menu) > 0 )
                    @foreach ($menu as $key=>$val)
                       @if ( isset($val['class']) && strlen($val['class']) > 0 )
                         <li class="{{ $val['class'] }} dropdown">
                       @else
                         <li class="dropdown">
                       @endif
                         @if(isset($val['children']) && ( $val['children'] > 0 ) )

                         <a href="{{ URL::base() }}/{{ $val['url'] }}"  class="dropdown-toggle">{{ $val['title'] }}</a>
                           
                         @else
                          <a href="{{ URL::base() }}/{{ $val['url'] }}">
                              {{ $val['title'] }}
                          </a>                         
                         @endif

                       
                       @if(isset($val['children']) && ( $val['children'] > 0 ) )
                       <ul class="dropdown-menu multilevel" role="menu">
                          @foreach( $val['children'] as $child )
                          
                            <li> 
                                <a href="{{ URL::base() }}/{{ $child['url'] }}">{{ $child['title'] }}</a>
                             </li>
                          
                          @endforeach
                       </ul>
                       @endif
                         </li>
                    @endforeach
                  @endif
                  
        </ul>
        
      </div>
      </div>
     </div>
     
	</nav><!-- end Navigation Menu -->      
        
        
        
                