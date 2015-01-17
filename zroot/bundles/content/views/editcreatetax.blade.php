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
								<form action="{{URL::base()}}/{{Config::get('admin::config.admin_url')}}content/submittax" enctype="multipart/form-data" method="POST" class='form-validate form-horizontal form-bordered' id="editcreate">
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
                      @if ( isset($data['text']) && count($data['text']) > 0 )
                        @foreach ( $data['text'] as $text )
                           {{ $text }}
                        @endforeach
                      @endif
                      @if ( isset($data['textarea']) && count($data['textarea']) > 0 )
                        @foreach ( $data['textarea'] as $textarea )
                           {{ $textarea }}
                        @endforeach
                      @endif
                      @if ( isset($data['select']) && count($data['select']) > 0 )
                        @foreach ( $data['select'] as $select )
                           {{ $select }}
                        @endforeach
                      @endif
                      @if ( isset($data['multiple']) && count($data['multiple']) > 0 )
                        @foreach ( $data['multiple'] as $multiple )
                           {{ $multiple }}
                        @endforeach
                      @endif 
                      @if ( isset($data['password']) && count($data['password']) > 0 )
                        @foreach ( $data['password'] as $password )
                           {{ $password }}
                        @endforeach
                      @endif
                      @if ( isset($data['file']) && count($data['file']) > 0 )
                        @foreach ( $data['file'] as $file )
                           {{ $file }}
                        @endforeach
                      @endif 
                      @if ( isset($data['checkbox']) && count($data['checkbox']) > 0 )
                        @foreach ( $data['checkbox'] as $checkbox )
                           {{ $checkbox }}
                        @endforeach
                      @endif
                      @if ( isset($data['hidden']) && count($data['hidden']) > 0 )
                        @foreach ( $data['hidden'] as $hidden )
                           {{ $hidden }}
                        @endforeach
                      @endif                       
									<div class="form-actions">
                    @if ( isset($data['action']) && $data['action'] == 'edit' )
										<input type="submit" name="edit" class="btn btn-primary" value="Save Changes">
                    <!-- <input type="submit" name="delete" class="btn btn-inverse" value="Delete"> -->
                    @elseif ( isset($data['action']) && $data['action'] == 'create' )
                    <input type="submit" name="create" class="btn btn-primary" value="Create">
                    @endif
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>