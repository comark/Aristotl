			<div class="row-fluid">
				<div class="span12">
					<div class="box box-color box-bordered">
						<div class="box-title">
							<h3>
								<i class="icon-user"></i>
								User profile
							</h3>
						</div>
						<div class="box-content nopadding">
							<ul class="tabs tabs-inline tabs-top">
								<li class='active'>
									<a href="#profile" data-toggle='tab'><i class="icon-user"></i> Profile</a>
								</li>
                <li>
                  <a href="#security" data-toggle='tab'><i class="icon-lock"></i> Change Password</a>
                </li>
							</ul>
							<div class="tab-content padding tab-content-inline tab-content-bottom">
								<div class="tab-pane active" id="profile">
									<form action="{{ URL::base()}}/{{ $admin_url }}xprofile/xupdate" method="post" class="form-horizontal form-validate" id="editprofile" enctype="multipart/form-data">
										<div class="row-fluid">
											<div class="span2">
                      @if ( isset($data['file']) && count($data['file']) > 0 )
                        @foreach ( $data['file'] as $file )
                           {{ $file }}
                        @endforeach
                      @endif
											</div>
											<div class="span10">
                      @if (Session::get('myerrors') )
                        <div class="control-group error">
                          <div class="controls">
                           <span class="help-block error" style="">{{Session::get('myerrors') }}</span>
                          </div>
                        </div>
                      @endif
                      @if ( count($errors->messages) > 0 )
                        <div class="control-group error">
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
												<div class="form-actions">
													<input type="submit" class='btn btn-primary' value="Save">
												</div>
											</div>
										</div>
									</form>
								</div>
                
								<div class="tab-pane" id="security">
									<form action="{{ URL::base()}}/{{ $admin_url }}xprofile/xchangepassword" method="post" class="form-horizontal form-validate" id="changepassword">
                      
                      @if ( isset($data['password']) && count($data['password']) > 0 )
                        @foreach ( $data['password'] as $password )
                           {{ $password }}
                        @endforeach
                      @endif
										<div class="form-actions">
											<input type="submit" class='btn btn-primary' value="Save">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>