        <div class="row-fluid">
          <div class="span12">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-envelope"></i>
                   Message Center
								</h3>
							</div>
							<div class="box-content nopadding">
@if ( isset($data)  )
								<table class="table table-hover table-nomargin dataTable table-bordered">
									<thead>
										<tr>
                      <th class='with-checkbox'><input type="checkbox" name="check_all" id="check_all"></th>
											<th>Action</th>
											<th class='hidden-350'>Message</th>
                      <th class='hidden-480'></th>
										</tr>
									</thead>
									<tbody>
                @if ( isset($data) && count($data)> 0 )
                  @foreach ($data as $key => $val )
										<tr>
                      <td class="with-checkbox">
												<input type="checkbox" name="check" value="{{ $val->id }}">
											</td>
                      <td>{{ ucwords($val->action) }}</td>
											<td>{{ $val->message }}</td>
                      <td class='hidden-480'>
                        <a href="{{ URL::base() }}}}" style=" margin-bottom: 3px; display: block">
                       <i class="icon-edit"></i>&nbsp;Edit
                     </a>
                      </td>
										</tr>                     
                  @endforeach
                @endif
									</tbody>
								</table>
@endif
							</div>
						</div>
					</div>
        </div>
				