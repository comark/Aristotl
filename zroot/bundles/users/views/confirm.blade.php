				<div class="row-fluid">
          <div class="span12">
            <div class="box box-color box-bordered lightred">
              
              <div class="box-title">
								<h3><i class="icon-remove"></i> 
                  @if (isset($data['form_title']))
                    {{ $data['form_title'] }}
                  @endif
                </h3>
							</div>
              <div class="box-content">
               <div class=""basic-margin>
                 <form action="{{URL::base()}}/users/delete" enctype="multipart/form-data" method="POST" class='form-validate form-bordered' id="delete">
                   <p>
                   @if ( isset($data['text'] ))
                     {{ $data['text'] }}
                   @endif
                   </p>
                    <div class="form-actions">
                     
                      <input type="hidden" name="id" value="{{ $data['id']}}">
                      <input type="submit" name="user_delete" class="btn btn-primary" value="Delete User">
                      <a href="{{ URL::base() }}/users/edit/{{ $data['id' ]}}" class="btn btn-inverse" >Cancel</a>
                    </div>               
                 </form>
               </div>
              </div>
              
            </div>
          </div>
        </div>