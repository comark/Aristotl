
      
        <ul class="nav navbar-nav navbar-right">
            @if (isset($menu) && count($menu) > 0 )
                    @foreach ($menu as $key=>$val)

                         @if(isset($val['children']) && ( $val['children'] > 0 ) )
                         <li class="dropdown">    
                                @if ( isset($val['class']) && strlen($val['class']) > 0 )
                            <a href="{{ URL::base() }}/{{ $val['url'] }}"  class="{{ $val['class'] }} dropdown-toggle">{{ $val['title'] }}</a>
                                @else                             
                            <a href="{{ URL::base() }}/{{ $val['url'] }}"  class=" dropdown-toggle">{{ $val['title'] }}</a>
                                @endif
                                
                            <span class="menu-toggler collapsed" data-toggle="collapse" data-target=".collapse-3">
                                    <i class="fa fa-angle-down"></i>
                            </span>                                
                         @else
                         <li class="">                             
                                @if ( isset($val['class']) && strlen($val['class']) > 0 )
                            <a href="{{ URL::base() }}/{{ $val['url'] }}"  class="{{ $val['class'] }} dropdown-toggle">{{ $val['title'] }}</a>
                                @else                             
                            <a href="{{ URL::base() }}/{{ $val['url'] }}"  class=" dropdown-toggle">{{ $val['title'] }}</a>
                                @endif  
                         @endif

                       
                       @if(isset($val['children']) && ( $val['children'] > 0 ) )
                       <ul role="menu" class="dropdown-menu collapse-3 collapse" >
                          @foreach( $val['children'] as $child )
                          
                            <li> 
                                <a style="white-space:normal !important;" href="{{ URL::base() }}/{{ $child['url'] }}">{{ $child['title'] }}</a>
                             </li>
                          
                          @endforeach
                       </ul>
                       @endif
                         </li>
                    @endforeach
                  @endif
                  
        </ul>
        

        
        
        
