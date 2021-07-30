@extends('dashboard.master')

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-pencil"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/assignments/list"><i class="fa fa-pencil"></i></a></li>
                    <li><a href="/assignments/list">Assignments</a></li>
                    <li>Assignment {{ $assignment->id }}</li>
                </ul>
                <h4>Assignment {{ $assignment->id }} / Student: {{$assignment->first_name.' '.$assignment->last_name}}</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">

        <div class="row row-stat">

            @if(Session::has('error_msg'))
                <div class="alert alert-danger">{{Session::get('error_msg')}}
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                </div>
            @endif

            @if(Session::has('success_msg'))
                <div class="alert alert-success">{{Session::get('success_msg')}}
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                </div>
            @endif

            {{Form::open(array('url'=>'/assignments/check/'.$assignment->id,'method'=>'post', 'class'=>'form-horizontal form-bordered'))}}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="time text-muted pull-right">
                        @if ($assignment->status == "created")
                          <span class="label label-success">Status: Available</span>
                        @elseif ($assignment->status == "open")
                          <span class="label label-info">Status: Opened</span>
                        @elseif ($assignment->status == "finished")
                          <span class="label label-danger">Status: Finished</span>
                        @elseif ($assignment->status == "finishedentry")
                          <span class="label label-info">Status: Time exceeded</span>
                        @endif
                        &nbsp;
                        <span class="label label-success">Created: <strong>{{ Carbon::createFromTimestamp(strtotime($assignment->date_created))->diffForHumans() }}</strong></span>
                        &nbsp;
                        <span class="label label-warning">Started:
                            <strong>{{ ($assignment->date_started == NULL) ? "Not yet" : Carbon::createFromTimestamp(strtotime($assignment->date_started))->diffForHumans() }}</strong>
                        </span>&nbsp;
                        <span class="label label-warning">Finished:
                            <strong>{{ ($assignment->date_finished == NULL) ? "Not yet" : Carbon::createFromTimestamp(strtotime($assignment->date_finished))->diffForHumans() }}</strong>
                        </span>
                    </span>
                    <h5 class="panel-title">{{ $course->name }}</h5>
                </div><!-- panel-heading -->

                <div class="panel-body">

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-desktop"></i> Virtual Machine</h3>
                            <div class="btn-group mr5 pull-right" style="margin-top:-20px">
                                <button type="button" class="btn btn-xs btn-primary">Action</button>
                                <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">
                                  <span class="caret"></span>
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                  <li><a href="/vmachine/{{$vmachine->id}}/operation/poweron">Power On</a></li>
                                  <li><a href="/vmachine/{{$vmachine->id}}/operation/reset">Reboot</a></li>
                                  <li><a href="/vmachine/{{$vmachine->id}}/operation/shutdown">Shutdown</a></li>
                                  <li><a href="/vmachine/{{$vmachine->id}}/operation/poweroff">Power Off</a></li>
                                  <li class="divider"></li>
                                  <li><a href="/vmachine/{{$vmachine->id}}/operation/delete">Pyhisical Delete</a></li>
                                  <li><a href="/vmachines/delete/{{$vmachine->id}}">Delete</a></li>
                                </ul>
                              </div>
                        </div>
                        <div class="panel-body">
                            <div class="media">
                                <div class="media-body">
                                    @if ($vmachine->console == '')
                                    <a href="/vmachine/console/{{$vmachine->id}}/{{$assignment->id}}">
                                      <button class="btn btn-default pull-right" type="button">Request Console</button>
                                    </a>
                                    @else
                                    <span class="pull-right">
                                      <a href="{{ $vmachine->console }}" target="_blank" style="margin-right:10px">
                                        <button class="btn btn-success" type="button">Open Console</button>
                                      </a>
                                      <a href="/vmachine/console/{{$vmachine->id}}/{{$assignment->id}}">
                                        <button class="btn btn-info" type="button"><i class="fa fa-circle-o"></i> Reset Console</button>
                                      </a>
                                    </span>
                                    @endif

                                    <div class="media-content">
                                        Virtual Machine: <span class="text-primary">{{ $vmachine->machine_id. ' / '. $vmachine->machine_name }}</span>
                                        &nbsp; Assignment scenarios: 
                                        @if ($vmachine->scenarios == 7)
                                            <span class="label label-info">Phishing, SQL, DDOS</span>
                                        @elseif ($vmachine->scenarios == 1) 
                                            <span class="label label-info">Phishing</span>
                                        @elseif ($vmachine->scenarios == 2) 
                                            <span class="label label-info">SQL</span>
                                        @elseif ($vmachine->scenarios == 3) 
                                            <span class="label label-info">Phishing, SQL</span>
                                        @elseif ($vmachine->scenarios == 4) 
                                            <span class="label label-info">DDOS</span>
                                        @elseif ($vmachine->scenarios == 5) 
                                            <span class="label label-info">Phishing, DDOS</span>
                                        @elseif ($vmachine->scenarios == 6) 
                                            <span class="label label-info">SQL, DDOS</span>
                                        @endif
                                        &nbsp; Credentials: <span class="text-primary">Autologin</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input name="assignment" type="hidden" value="{{ $assignment->id }}">


                    @foreach ($scenarios as $scenario)

                    @if ($scenario->type == "phishing") 

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Phishing Scenario</h3>
                            </div>

                            <div class="panel-body">

                                <p class="text-info"><i class="glyphicon glyphicon-hdd"></i> <strong>Note:</strong> Use <strong>HD2</strong> Disk in X-Ways.</p>
                            
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Choose correct attacker IP:</label>
                                    <div class="col-sm-8">
                                        <div class="radio"><label class="text-success"><input value="{{ $scenario->attacker_ip }}" name="ip_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_ip) && $scenario->result->attacker_ip == $scenario->attacker_ip ) ? 'checked' : '' }}> {{ $scenario->attacker_ip }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option1_ip }}" name="ip_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_ip) && $scenario->result->attacker_ip == $scenario->attacker_option1_ip ) ? 'checked' : '' }}> {{ $scenario->attacker_option1_ip }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option2_ip }}" name="ip_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_ip) && $scenario->result->attacker_ip == $scenario->attacker_option2_ip ) ? 'checked' : '' }}> {{ $scenario->attacker_option2_ip }}</label></div>
                                          
                                    </div><!-- col-sm-8 -->
                                </div><!-- form-group -->

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Choose correct date of attack:</label>
                                    <div class="col-sm-8">
                                        
                                        <div class="radio"><label class="text-success"><input value="{{ $scenario->attacker_date }}" name="date_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_date) && $scenario->result->attacker_date == $scenario->attacker_date ) ? 'checked' : '' }}> {{ $scenario->attacker_date }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option1_date }}" name="date_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_date) && $scenario->result->attacker_date == $scenario->attacker_option1_date ) ? 'checked' : '' }}> {{ $scenario->attacker_option1_date }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option2_date }}" name="date_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_date) && $scenario->result->attacker_date == $scenario->attacker_option2_date ) ? 'checked' : '' }}> {{ $scenario->attacker_option2_date }}</label></div>
                                          
                                    </div><!-- col-sm-8 -->
                                </div><!-- form-group -->

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Choose stolen data:</label>
                                    <div class="col-sm-8">
                                        
                                        <div class="radio"><label class="text-success"><input value="{{ $scenario->attacker_stolen_data }}" name="sd_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_stolen_data) && $scenario->result->attacker_stolen_data == $scenario->attacker_stolen_data ) ? 'checked' : '' }}> {{ $scenario->attacker_stolen_data }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option1_stolen_data }}" name="sd_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_stolen_data) && $scenario->result->attacker_stolen_data == $scenario->attacker_option1_stolen_data ) ? 'checked' : '' }}> {{ $scenario->attacker_option1_stolen_data }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option2_stolen_data }}" name="sd_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_stolen_data) && $scenario->result->attacker_stolen_data == $scenario->attacker_option2_stolen_data ) ? 'checked' : '' }}> {{ $scenario->attacker_option2_stolen_data }}</label></div>
                                          
                                    </div><!-- col-sm-8 -->
                                </div><!-- form-group -->

                            </div>
                        </div>

                    @elseif ($scenario->type == "sql")

                        <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">SQL Scenario</h3>
                                </div>

                                <div class="panel-body">

                                    <p class="text-info"><i class="glyphicon glyphicon-hdd"></i> <strong>Note:</strong> Use <strong>HD1</strong> Disk in X-Ways.</p>
                                
                                    <div class="form-group">
                                    <label class="col-sm-4 control-label">Choose correct attacker IP:</label>
                                    <div class="col-sm-8">
                                        
                                        <div class="radio"><label class="text-success"><input value="{{ $scenario->attacker_ip }}" name="ip_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_ip) && $scenario->result->attacker_ip == $scenario->attacker_ip ) ? 'checked' : '' }}> {{ $scenario->attacker_ip }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option1_ip }}" name="ip_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_ip) && $scenario->result->attacker_ip == $scenario->attacker_option1_ip ) ? 'checked' : '' }}> {{ $scenario->attacker_option1_ip }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option2_ip }}" name="ip_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_ip) && $scenario->result->attacker_ip == $scenario->attacker_option2_ip ) ? 'checked' : '' }}> {{ $scenario->attacker_option2_ip }}</label></div>
                                          
                                    </div><!-- col-sm-8 -->
                                </div><!-- form-group -->

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Choose correct date of attack:</label>
                                    <div class="col-sm-8">
                                        
                                        <div class="radio"><label class="text-success"><input value="{{  $scenario->attacker_date }}" name="date_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_date) && $scenario->result->attacker_date == $scenario->attacker_date ) ? 'checked' : '' }}> {{ $scenario->attacker_date }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option1_date }}" name="date_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_date) && $scenario->result->attacker_date == $scenario->attacker_option1_date ) ? 'checked' : '' }}> {{ $scenario->attacker_option1_date }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option2_date }}" name="date_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_date) && $scenario->result->attacker_date == $scenario->attacker_option2_date ) ? 'checked' : '' }}> {{ $scenario->attacker_option2_date }}</label></div>
                                          
                                    </div><!-- col-sm-8 -->
                                </div><!-- form-group -->

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Choose entrypoint file of attack:</label>
                                    <div class="col-sm-8">
                                        
                                        <div class="radio"><label class="text-success"><input value="{{ $scenario->attacker_entrypoint_file }}" name="epf_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_entrypoint_file) && $scenario->result->attacker_entrypoint_file == $scenario->attacker_entrypoint_file ) ? 'checked' : '' }}> {{ $scenario->attacker_entrypoint_file }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option1_entrypoint_file }}" name="epf_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_entrypoint_file) && $scenario->result->attacker_entrypoint_file == $scenario->attacker_option1_entrypoint_file ) ? 'checked' : '' }}> {{ $scenario->attacker_option1_entrypoint_file }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option2_entrypoint_file }}" name="epf_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_entrypoint_file) && $scenario->result->attacker_entrypoint_file == $scenario->attacker_option2_entrypoint_file ) ? 'checked' : '' }}> {{ $scenario->attacker_option2_entrypoint_file }}</label></div>
                                          
                                    </div><!-- col-sm-8 -->
                                </div><!-- form-group -->

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Choose entrypoint line of attack:</label>
                                    <div class="col-sm-8">
                                        
                                        <div class="radio"><label class="text-success"><input value="{{ $scenario->attacker_entrypoint_line }}" name="epl_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_entrypoint_line) && $scenario->result->attacker_entrypoint_line == $scenario->attacker_entrypoint_line ) ? 'checked' : '' }}> {{ $scenario->attacker_entrypoint_line }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option1_entrypoint_line }}" name="epl_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_entrypoint_line) && $scenario->result->attacker_entrypoint_line == $scenario->attacker_option1_entrypoint_line ) ? 'checked' : '' }}> {{ $scenario->attacker_option1_entrypoint_line }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option2_entrypoint_line }}" name="epl_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_entrypoint_line) && $scenario->result->attacker_entrypoint_line == $scenario->attacker_option2_entrypoint_line ) ? 'checked' : '' }}> {{ $scenario->attacker_option2_entrypoint_line }}</label></div>
                                          
                                    </div><!-- col-sm-8 -->
                                </div><!-- form-group -->

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Choose stolen data:</label>
                                    <div class="col-sm-8">
                                        
                                        <div class="radio"><label class="text-success"><input value="{{ $scenario->attacker_stolen_data }}" name="sd_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_stolen_data) && $scenario->result->attacker_stolen_data == $scenario->attacker_stolen_data ) ? 'checked' : '' }}> {{ $scenario->attacker_stolen_data }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option1_stolen_data }}" name="sd_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_stolen_data) && $scenario->result->attacker_stolen_data == $scenario->attacker_option1_stolen_data ) ? 'checked' : '' }}> {{ $scenario->attacker_option1_stolen_data }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option2_stolen_data }}" name="sd_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_stolen_data) && $scenario->result->attacker_stolen_data == $scenario->attacker_option2_stolen_data ) ? 'checked' : '' }}> {{ $scenario->attacker_option2_stolen_data }}</label></div>
                                          
                                    </div><!-- col-sm-8 -->
                                </div><!-- form-group -->

                                </div>
                            </div>

                    @elseif ($scenario->type == "ddos")

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">DDOS Scenario</h3>
                            </div>

                            <div class="panel-body">

                                <p class="text-info"><i class="glyphicon glyphicon-hdd"></i> <strong>Note:</strong> Use <strong>HD3</strong> Disk in X-Ways.</p>
                            
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Choose correct attacker IP:</label>
                                    <div class="col-sm-8">
                                        
                                        <div class="radio"><label class="text-success"><input value="{{ $scenario->attacker_ip }}" name="ip_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_ip) && $scenario->result->attacker_ip == $scenario->attacker_ip ) ? 'checked' : '' }}> {{ $scenario->attacker_ip }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option1_ip }}" name="ip_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_ip) && $scenario->result->attacker_ip == $scenario->attacker_option1_ip ) ? 'checked' : '' }}> {{ $scenario->attacker_option1_ip }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option2_ip }}" name="ip_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_ip) && $scenario->result->attacker_ip == $scenario->attacker_option2_ip ) ? 'checked' : '' }}> {{ $scenario->attacker_option2_ip }}</label></div>
                                          
                                    </div><!-- col-sm-8 -->
                                </div><!-- form-group -->

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Choose correct date of attack:</label>
                                    <div class="col-sm-8">
                                        
                                        <div class="radio"><label class="text-success"><input value="{{ $scenario->attacker_date }}" name="date_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_date) && $scenario->result->attacker_date == $scenario->attacker_date ) ? 'checked' : '' }}> {{ $scenario->attacker_date }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option1_date }}" name="date_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_date) && $scenario->result->attacker_date == $scenario->attacker_option1_date ) ? 'checked' : '' }}> {{ $scenario->attacker_option1_date }}</label></div>
                                        <div class="radio"><label><input value="{{ $scenario->attacker_option2_date }}" name="date_{{$scenario->id}}" type="radio" {{ (isset($scenario->result->attacker_date) && $scenario->result->attacker_date == $scenario->attacker_option2_date ) ? 'checked' : '' }}> {{ $scenario->attacker_option2_date }}</label></div>
                                          
                                    </div><!-- col-sm-8 -->
                                </div><!-- form-group -->

                            </div>
                        </div>

                    @endif

                @endforeach

                </div><!-- panel-body -->

                 <div class="panel-footer"> 
                    <div class="pull-right">
                        <button class="btn btn-primary mr5" id="submit_btn">Submit</button>
                    </div>
                </div><!-- panel footer end -->

                
            </div><!-- panel -->   
            {{Form::close()}}

        </div><!-- end row -->

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop