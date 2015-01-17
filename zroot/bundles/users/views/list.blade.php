        <div class="row-fluid">
          <div class="span12">
              
						<div class="box box-color box-bordered">
							<div class="box-title"><a name="results" style="float:left; display:block;"></a>
								<h3>
									<i class="icon-table"></i>
									@if ( isset($title) ) 
                   {{ $title }}
                  @endif 
								</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                      <th></th>
											<th>Email</th>
                      <th class='hidden-480'>Activated</th>
                      <th class='hidden-480'></th>
										</tr>
									</thead>
									<tbody>
                @if ( isset($data) && count($data)> 0 )
                  @foreach ($data as $user_key => $user )
										<tr>
                      <td>{{ $user->get('id') }}</td>
											<td>{{ $user->get('email') }}</td>
                      @if ( $user->get('activated') == '1' )
                      <td class='hidden-480'>Yes</td>
                      @else 
                      <td class='hidden-480'>No</td>
                      @endif
                      <td class='hidden-480'>

<a href="{{ URL::base() }}/users/edit/{{ $user->get('id') }}" style=" margin-bottom: 3px; display: block">   
   <i class="icon-edit"></i>&nbsp;Edit
</a>  
                             
                      
                     </a>
										</tr>                     
                  @endforeach
                @endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
        </div>
				