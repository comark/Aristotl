@if ( isset($left_menu) && count($left_menu) > 0 )
  @foreach ( $left_menu as $lm )
  <div class="subnav">
    @if ( isset($lm['left_menu']) && count($lm['left_menu']) > 0 )
      @if ( isset( $lm['left_menu']['left_title'] ) )
      <div class="subnav-title">
        <a href="#" class='toggle-subnav'>
          <i class="icon-angle-down"></i>
          <span>{{ $lm['left_menu']['left_title'] }}</span>
        </a>
      </div>
      <!---->
        @if ( isset($lm['left_menu']['level1']) && count($lm['left_menu']['level1']) > 0 )
          <ul class="subnav-menu">
           @foreach ($lm['left_menu']['level1'] as $level1_key => $level1_val )
             @if ( isset($level1_val['dropdown']) )
              <li class='dropdown'>
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                  {{ $level1_val['title'] }}
                </a>
                @if ( isset($lm['left_menu']['level2']) && count($lm['left_menu']['level2']) > 0 )
                <ul class="dropdown-menu">
                  @foreach ($lm['left_menu']['level2'] as $level2_key => $level2_val )
                    @if ( $level2_val['parent'] ==  $level1_key )
                    <li>
                      <a href="{{ URL::base().'/'.Config::get('admin::config.admin_url').$lm['root_link'].'/'.$level2_val['controller_func'] }}">
                        {{ $level2_val['title'] }}
                      </a>
                    </li>
                    @endif
                  @endforeach
                </ul>
                @endif
              </li>           
             @else
              <li>
                <a href="{{ URL::base().'/'.Config::get('admin::config.admin_url').$lm['root_link'].'/'.$level1_val['controller_func'] }}">
                  {{ $level1_val['title'] }}
                </a>
              </li>  
             @endif        
           @endforeach
          </ul>
        @endif
      <!---->
      @endif
    @endif
  </div>
  @endforeach
@endif
    