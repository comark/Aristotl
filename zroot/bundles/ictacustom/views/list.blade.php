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
                @if ( isset($data['posts']) )
                <table class="table table-hover table-nomargin searchTable dataTable-tools dataTable-nofooter table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th class='hidden-350'>Status</th>
                            <th class='hidden-480'>Updated</th>
                            <th class='hidden-480'></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ( isset($data['posts']) && count($data['posts'])> 0 )
                        @foreach ($data['posts'] as $post_key => $post )
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->type }}</td>
                            <td class='hidden-350'>{{ $post->status }}</td>
                            <td class='hidden-1024'>{{ $post->updated_at }}</td>

                            <td class='hidden-480'>
                                <a href="{{ URL::base() }}/{{Config::get('admin::config.admin_url')}}ictacustom/edit/{{ $post->type }}/{{ $post->id }}" style=" margin-bottom: 3px; display: block">
                                    <i class="icon-edit"></i>&nbsp;Edit
                                </a>
                            </td>
                        </tr>                     
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="dataTables_info"></div>
                <div class="dataTables_paginate">
                @if(isset($data['pagination']))
                    {{ $data['pagination'] }}
                @endif
                </div>                
                @endif
            </div>
        </div>
    </div>
</div>
