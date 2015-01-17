				<div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-th-list"></i> 
                  @if (isset($data['form_title']))
                    {{ $data['form_title'] }}
                  @endif
                </h3>
							</div>
							<div class="box-content nopadding">
								<form action="{{ URL::base() }}/{{Config::get('admin::config.admin_url')}}{{ $data['submit_url'] }}" enctype="multipart/form-data" method="POST"  class='form-validate form-horizontal form-bordered' id="editcreate">
                      @if ( Session::get('myerrors') )
                        <div class="control-group error">
                          <div class="controls">
                           <span class="help-block error" style="">{{ Session::get('myerrors') }}</span>
                          </div>
                        </div>
                      @endif
                      @if ( count($errors->messages) > 0 )
                        <div class="control-group error">
                          <label for="errors" class="control-label">Errors</label>
                          <div class="controls">
                          @foreach ( $errors->messages as $key => $val)  
                          <span class="help-block error" style="">{{ $val[0]}}</span>
                          @endforeach
                          </div>
                        </div>
                      @endif
    @if(isset($data['input_items']))
    @foreach ($data['input_items'] as $data_key => $data_val)
    @if ( isset($data_val['title']) && count($data_val['title']) > 0 )
    @foreach ( $data_val['title'] as $title )
    {{ $title }}
    @endforeach
    @endif                 
    @if ( isset($data_val['text']) && count($data_val['text']) > 0 )
    @foreach ( $data_val['text'] as $text )
    {{ $text }}
    @endforeach
    @endif
    @if ( isset($data_val['datetime']) && count($data_val['datetime']) > 0 )
    @foreach ( $data_val['datetime'] as $datetime )
    {{ $datetime }}
    @endforeach
    @endif                      
    @if ( isset($data_val['textarea']) && count($data_val['textarea']) > 0 )
    @foreach ( $data_val['textarea'] as $textarea )
    {{ $textarea }}
    @endforeach
    @endif
    @if ( isset($data_val['select']) && count($data_val['select']) > 0 )
    @foreach ( $data_val['select'] as $select )
    {{ $select }}
    @endforeach
    @endif
    @if ( isset($data_val['multiple']) && count($data_val['multiple']) > 0 )
    @foreach ( $data_val['multiple'] as $multiple )
    {{ $multiple }}
    @endforeach
    @endif 
    @if ( isset($data_val['password']) && count($data_val['password']) > 0 )
    @foreach ( $data_val['password'] as $password )
    {{ $password }}
    @endforeach
    @endif
    @if ( isset($data_val['file']) && count($data_val['file']) > 0 )
    @foreach ( $data_val['file'] as $file )
    {{ $file }}
    @endforeach
    @endif 
    
    @if ( isset($data_val['upload']) && count($data_val['upload']) > 0 )
    @foreach ( $data_val['upload'] as $upload )
    {{ $upload }}
    @endforeach
    @endif     
    
    @if ( isset($data_val['checkbox']) && count($data_val['checkbox']) > 0 )
    @foreach ( $data_val['checkbox'] as $checkbox )
    {{ $checkbox }}
    @endforeach
    @endif
    @if ( isset($data_val['hr']) && count($data_val['hr']) > 0 )
    @foreach ( $data_val['hr'] as $hr )
    {{ $hr }}
    @endforeach
    @endif                    
    @if ( isset($data_val['hidden']) && count($data_val['hidden']) > 0 )
    @foreach ( $data_val['hidden'] as $hidden )
    {{ $hidden }}
    @endforeach
    @endif

    @endforeach
    @endif                      
									<div class="form-actions">
                    @if( isset($data['saveonly']))
                      <input type="submit" name="save" class="btn btn-primary" value="Save Changes">
                    @elseif ( isset($data['submit']))
                      <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                    @else
                      @if ( isset($data['action']) && $data['action'] == 'edit' )
                      <input type="submit" name="edit" class="btn btn-primary" value="Save Changes">
                      <input type="submit" name="delete" class="btn btn-inverse" value="Delete">
                      @elseif ( isset($data['action']) && $data['action'] == 'create' )
                      <input type="submit" name="create" class="btn btn-primary" value="Create">
                      @endif                     
                    @endif
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>