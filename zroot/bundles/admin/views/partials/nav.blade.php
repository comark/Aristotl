@if ( isset($top_menu) && count($top_menu) > 0  )
   @foreach ( $top_menu as $tm )
      <!--li-->

      
      @if ( isset($tm['sub_menu']) && count($tm['sub_menu']) > 0 )
         @if ( isset($tm['active'] )  )
           <li class='active'>
         @else
           <li>
         @endif
          <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
            <span>{{ $tm['title'] }}</span>
            <span class="caret"></span>
          </a>
         @if ( isset($tm['sub_menu']['level1']) && count($tm['sub_menu']['level1']) > 0 )
          <ul class="dropdown-menu">
           @foreach ($tm['sub_menu']['level1'] as $level1_key => $level1_val )
             @if ( isset($level1_val['dropdown']) )
              <li class='dropdown-submenu'>
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                  {{ $level1_val['title'] }}
                </a>
                @if (isset($tm['sub_menu']['level2']) && count($tm['sub_menu']['level2']) > 0 )
                <ul class="dropdown-menu">
                  @foreach ($tm['sub_menu']['level2'] as $level2_key => $level2_val )
                    @if ( $level2_val['parent'] ==  $level1_key )
                    
                       @if (isset($level2_val['dropdown']))
                        <li class='dropdown-submenu'>
                          <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                            {{ $level2_val['title'] }}
                          </a>
                          <ul class="dropdown-menu">
                           @foreach ($tm['sub_menu']['level3'] as $level3_key => $level3_val )
                             @if ( $level3_val['parent'] ==  $level2_key )
                              <li>
                                <a href="{{ URL::base().'/'.Config::get('admin::config.admin_url').$tm['root_link'].'/'.$level3_val['controller_func'] }}">{{ $level3_val['title'] }}</a>
                              </li>                         
                             @endif                           
                           @endforeach
                          </ul>
                        </li>
                       @else
                       <li>
                         <a href="{{ URL::base().'/'.Config::get('admin::config.admin_url').$tm['root_link'].'/'.$level2_val['controller_func'] }}">{{ $level2_val['title'] }}</a>
                       </li>
                      @endif
                    @endif
                  @endforeach
                </ul>
                @endif
              </li>           
             @else
              <li>
                <a href="{{ URL::base().'/'.Config::get('admin::config.admin_url').$tm['root_link'].'/'.$level1_val['controller_func'] }}">
                  {{ $level1_val['title'] }}
                </a>
              </li>  
             @endif        
           @endforeach
          </ul>
         @endif
      @endif      
      <!-- end li -->
   @endforeach
@endif