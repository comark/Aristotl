        <div class="row-fluid">
          <div class="span12">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="icon-table"></i>
									@if ( isset($title) ) 
                   {{ $title }}
                  @endif 
								</h3>
							</div>
							<div class="box-content nopadding">
@if ( isset($data['taxs']) )
								<table class="table table-hover table-nomargin dataTable table-bordered">
									<thead>
										<tr>
											<th>ID</th>
											<th>Title</th>
                      <th class='hidden-350'>Status</th>
											<th class='hidden-1024'>Created</th>
											<th class='hidden-480'>Updated</th>
                      <th class='hidden-480'></th>
										</tr>
									</thead>
									<tbody>
                @if ( isset($data['taxs']) && count($data['taxs'])> 0 )
                  @foreach ($data['taxs'] as $tax_key => $tax )
										<tr>
											<td>{{ $tax->id }}</td>
											<td>{{ $tax->title }}</td>
											<td class='hidden-350'>{{ $tax->status }}</td>
                      <td class='hidden-350'>{{ $tax->created_at }}</td>
											<td class='hidden-1024'>{{ $tax->updated_at }}</td>

                      <td class='hidden-480'>
                        <a href="{{ URL::base() }}/{{Config::get('admin::config.admin_url')}}content/editcategory/{{ $tax->id }}" style=" margin-bottom: 3px; display: block">
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
				