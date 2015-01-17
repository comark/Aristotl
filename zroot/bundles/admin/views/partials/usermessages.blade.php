        <ul class="icon-nav">
          <li class='dropdown'>
            <a href="#" class='dropdown-toggle' data-toggle="dropdown">
              <i class="icon-envelope-alt"></i>
              @if ( isset($count) && ($count > 0)) 
              <span class="label label-lightred">{{$count}}</span>
              @endif
            </a>
            <ul class="dropdown-menu pull-right message-ul">
              @if (isset($messages) && (count($messages) > 0 ))
                @foreach ($messages as $message )
              <li>
                <a href="{{ URL::base().'/notihandler/'.$message->id}}">
                  <div class="details">
                    <div class="name">{{ ucwords($message->action) }}</div>
                    <div class="message">
                      {{ $message->message }}
                    </div>
                  </div>
                </a>
              </li>
                @endforeach
              @endif
              <li>
                <a href="{{ URL::base().'/notimessages' }}" class='more-messages'>Go to Message center
                  <i class="icon-arrow-right"></i>
                </a>
              </li>
            </ul>
          </li>
