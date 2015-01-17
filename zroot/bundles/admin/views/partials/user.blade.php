        <div class="dropdown">
          <a href="#" class='dropdown-toggle' data-toggle="dropdown">
            {{ Sentry::user()->get('metadata.first_name') }} {{ Sentry::user()->get('metadata.last_name') }}
            @if ( Sentry::user()->get('metadata.avatar') )
            <img style="max-width:27px; max-height:27px;" src="{{ URL::base() }}/{{ Sentry::user()->get('metadata.avatar') }}" alt="">
            @else
            <img style="max-width:27px; max-height:27px;" src="{{ URL::base() }}/admin_assets/img/aristotle.jpg" alt="">
            @endif
          </a>
          <ul class="dropdown-menu pull-right">
            <li>
              <a href="{{ URL::base() }}/{{ Config::get('admin::config.admin_url') }}xprofile">View profile</a>
            </li>
            <li>
              <a href="{{ URL::base() }}/{{ Config::get('admin::config.admin_url') }}xlogout">Sign out</a>
            </li>
          </ul>
        </div>