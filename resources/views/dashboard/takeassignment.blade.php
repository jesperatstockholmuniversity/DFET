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
                <h4>Assignment {{ $assignment->id }}</h4>
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
                        <span class="label label-info"><i class="fa fa-clock-o"></i> Assignment started: {{ Carbon::createFromTimestamp(strtotime($assignment->date_started))->diffForHumans() }}</span>&nbsp;
                        <span class="label label-success"><i class="fa fa-clock-o"></i> Estimated time: {{ $assignment->time }} min.</span>
                    </span>
                    <h5 class="panel-title">{{ $course->name }} Assignment</h5>
                    <p>Below are questions separated in groups. Please check twice before submitting your answer.</p>
                </div><!-- panel-heading -->

                <div class="panel-body">

                    <!--div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-desktop"></i> Virtual Machine</h3>
                        </div>
                        <div class="panel-body">
                            <div class="media">
                                <div class="media-body">
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
                    </div-->

                    <input name="assignment" type="hidden" value="{{ $assignment->id }}">

                    @if ($vmachine->console == "")
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                @if ($vmachine->console == '')
                                    <a href="/vmachine/console/{{$vmachine->id}}/{{$assignment->id}}">
                                      <button class="btn btn-primary pull-right" type="button">Request Console</button>
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
                                <h3 class="panel-title">Assignments</h3>
                            </div>
                            <div class="panel-body">
                                <span class="lead"><i class="fa fa-exclamation"></i> This content will be available as soon as you request virtual machine console.</span>
                            </div><!-- panel-body -->
                        </div>
                    @else 

                        @foreach ($scenarios as $scenario)

                        @if ($scenario->type == "phishing") 


                            <?php

                                $ip = array( 
                                    $scenario->attacker_ip, 
                                    $scenario->attacker_option1_ip, 
                                    $scenario->attacker_option2_ip 
                                    );

                                shuffle($ip);

                                $date = array(
                                    $scenario->attacker_date,
                                    $scenario->attacker_option1_date,
                                    $scenario->attacker_option2_date
                                    );

                                shuffle($date);

                                $stolen_data = array(
                                    $scenario->attacker_stolen_data,
                                    $scenario->attacker_option1_stolen_data,
                                    $scenario->attacker_option2_stolen_data
                                    );

                                shuffle($stolen_data);
                            
                            ?>

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    @if ($vmachine->console == '')
                                        <a href="/vmachine/console/{{$vmachine->id}}/{{$assignment->id}}">
                                          <button class="btn btn-primary pull-right" type="button">Request Console</button>
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
                                    <h3 class="panel-title">Phishing Scenario</h3>
                                </div>

                                <div class="panel-body">

                                    <p class="text-info"><i class="glyphicon glyphicon-hdd"></i> <strong>Note:</strong> Use <strong>HD2</strong> Disk in X-Ways.</p>
                                     <p class="text-default"><strong>Description of attack:</strong>
                                        An attacker tried to gain access to the web hosting server using brute force tool. Through ssh he gained access to the server, where he explored the environment (mysql, apache etc.) for possible useful information. Attacker uploaded website and left it running for a while and gained victoms data. At the end he deleted his uploaded data. Find the correct answers below.
                                        </p>
                                
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Choose correct attacker IP:</label>
                                        <div class="col-sm-8">
                                            
                                            <div class="radio"><label><input value="{{ $ip[0] }}" name="ip_{{$scenario->id}}" type="radio" {{ (Input::old('ip_'.$scenario->id) == $ip[0]) ? 'checked' : '' }}> {{ $ip[0] }}</label></div>
                                            <div class="radio"><label><input value="{{ $ip[1] }}" name="ip_{{$scenario->id}}" type="radio" {{ (Input::old('ip_'.$scenario->id) == $ip[1]) ? 'checked' : '' }}> {{ $ip[1] }}</label></div>
                                            <div class="radio"><label><input value="{{ $ip[2] }}" name="ip_{{$scenario->id}}" type="radio" {{ (Input::old('ip_'.$scenario->id) == $ip[2]) ? 'checked' : '' }}> {{ $ip[2] }}</label></div>
                                              
                                        </div><!-- col-sm-8 -->
                                    </div><!-- form-group -->

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Choose correct date of attack:</label>
                                        <div class="col-sm-8">
                                            
                                            <div class="radio"><label><input value="{{ $date[0] }}" name="date_{{$scenario->id}}" type="radio" {{ (Input::old('date_'.$scenario->id) == $date[0]) ? 'checked' : '' }}> {{ $date[0] }}</label></div>
                                            <div class="radio"><label><input value="{{ $date[1] }}" name="date_{{$scenario->id}}" type="radio" {{ (Input::old('date_'.$scenario->id) == $date[1]) ? 'checked' : '' }}> {{ $date[1] }}</label></div>
                                            <div class="radio"><label><input value="{{ $date[2] }}" name="date_{{$scenario->id}}" type="radio" {{ (Input::old('date_'.$scenario->id) == $date[2]) ? 'checked' : '' }}> {{ $date[2] }}</label></div>
                                              
                                        </div><!-- col-sm-8 -->
                                    </div><!-- form-group -->

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Choose stolen data:</label>
                                        <div class="col-sm-8">
                                            
                                            <div class="radio"><label><input value="{{ $stolen_data[0] }}" name="sd_{{$scenario->id}}" type="radio" {{ (Input::old('sd_'.$scenario->id) == $stolen_data[0]) ? 'checked' : '' }}> {{ $stolen_data[0] }}</label></div>
                                            <div class="radio"><label><input value="{{ $stolen_data[1] }}" name="sd_{{$scenario->id}}" type="radio" {{ (Input::old('sd_'.$scenario->id) == $stolen_data[1]) ? 'checked' : '' }}> {{ $stolen_data[1] }}</label></div>
                                            <div class="radio"><label><input value="{{ $stolen_data[2] }}" name="sd_{{$scenario->id}}" type="radio" {{ (Input::old('sd_'.$scenario->id) == $stolen_data[2]) ? 'checked' : '' }}> {{ $stolen_data[2] }}</label></div>
                                              
                                        </div><!-- col-sm-8 -->
                                    </div><!-- form-group -->

                                </div>
                            </div>

                        @elseif ($scenario->type == "sql")

                            <?php

                                $ip = array( 
                                    $scenario->attacker_ip, 
                                    $scenario->attacker_option1_ip, 
                                    $scenario->attacker_option2_ip 
                                    );

                                shuffle($ip);

                                $date = array(
                                    $scenario->attacker_date,
                                    $scenario->attacker_option1_date,
                                    $scenario->attacker_option2_date
                                    );

                                shuffle($date);

                                $entrypoint_file = array(
                                    $scenario->attacker_entrypoint_file,
                                    $scenario->attacker_option1_entrypoint_file,
                                    $scenario->attacker_option2_entrypoint_file
                                    );

                                shuffle($entrypoint_file);

                                $entrypoint_line = array(
                                    $scenario->attacker_entrypoint_line,
                                    $scenario->attacker_option1_entrypoint_line,
                                    $scenario->attacker_option2_entrypoint_line
                                    );

                                shuffle($entrypoint_line);

                                $stolen_data = array(
                                    $scenario->attacker_stolen_data,
                                    $scenario->attacker_option1_stolen_data,
                                    $scenario->attacker_option2_stolen_data
                                    );

                                shuffle($stolen_data);
                            
                            ?>

                            <div class="panel panel-info">
                                    <div class="panel-heading">
                                        @if ($vmachine->console == '')
                                            <a href="/vmachine/console/{{$vmachine->id}}/{{$assignment->id}}">
                                              <button class="btn btn-primary pull-right" type="button">Request Console</button>
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
                                        <h3 class="panel-title">SQL Scenario</h3>
                                    </div>

                                    <div class="panel-body">

                                        <p class="text-info"><i class="glyphicon glyphicon-hdd"></i> <strong>Note:</strong> Use <strong>HD1</strong> Disk in X-Ways.</p>
                                        <p class="text-default"><strong>Description of attack:</strong>
                                        An attacker accessed the website and tried login forms, where he later performed sql injection with the sqlmap tool. Attack was successful and he uploaded a script that gave him data access. Find the correct answers below.
                                        </p>
                                    
                                        <div class="form-group">
                                        <label class="col-sm-4 control-label">Choose correct attacker IP:</label>
                                        <div class="col-sm-8">
                                            
                                            <div class="radio"><label><input value="{{ $ip[0] }}" name="ip_{{$scenario->id}}" type="radio" {{ (Input::old('ip_'.$scenario->id) == $ip[0]) ? 'checked' : '' }}> {{ $ip[0] }}</label></div>
                                            <div class="radio"><label><input value="{{ $ip[1] }}" name="ip_{{$scenario->id}}" type="radio" {{ (Input::old('ip_'.$scenario->id) == $ip[1]) ? 'checked' : '' }}> {{ $ip[1] }}</label></div>
                                            <div class="radio"><label><input value="{{ $ip[2] }}" name="ip_{{$scenario->id}}" type="radio" {{ (Input::old('ip_'.$scenario->id) == $ip[2]) ? 'checked' : '' }}> {{ $ip[2] }}</label></div>
                                              
                                        </div><!-- col-sm-8 -->
                                    </div><!-- form-group -->

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Choose correct date of attack:</label>
                                        <div class="col-sm-8">
                                            
                                            <div class="radio"><label><input value="{{ $date[0] }}" name="date_{{$scenario->id}}" type="radio" {{ (Input::old('date_'.$scenario->id) == $date[0]) ? 'checked' : '' }}> {{ $date[0] }}</label></div>
                                            <div class="radio"><label><input value="{{ $date[1] }}" name="date_{{$scenario->id}}" type="radio" {{ (Input::old('date_'.$scenario->id) == $date[1]) ? 'checked' : '' }}> {{ $date[1] }}</label></div>
                                            <div class="radio"><label><input value="{{ $date[2] }}" name="date_{{$scenario->id}}" type="radio" {{ (Input::old('date_'.$scenario->id) == $date[2]) ? 'checked' : '' }}> {{ $date[2] }}</label></div>
                                              
                                        </div><!-- col-sm-8 -->
                                    </div><!-- form-group -->

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Choose entrypoint file of attack:</label>
                                        <div class="col-sm-8">
                                            
                                            <div class="radio"><label><input value="{{ $entrypoint_file[0] }}" name="epf_{{$scenario->id}}" type="radio" {{ (Input::old('epf_'.$scenario->id) == $entrypoint_file[0]) ? 'checked' : '' }}> {{ $entrypoint_file[0] }}</label></div>
                                            <div class="radio"><label><input value="{{ $entrypoint_file[1] }}" name="epf_{{$scenario->id}}" type="radio" {{ (Input::old('epf_'.$scenario->id) == $entrypoint_file[1]) ? 'checked' : '' }}> {{ $entrypoint_file[1] }}</label></div>
                                            <div class="radio"><label><input value="{{ $entrypoint_file[2] }}" name="epf_{{$scenario->id}}" type="radio" {{ (Input::old('epf_'.$scenario->id) == $entrypoint_file[2]) ? 'checked' : '' }}> {{ $entrypoint_file[2] }}</label></div>
                                              
                                        </div><!-- col-sm-8 -->
                                    </div><!-- form-group -->

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Choose entrypoint line of attack:</label>
                                        <div class="col-sm-8">
                                            
                                            <div class="radio"><label><input value="{{ $entrypoint_line[0] }}" name="epl_{{$scenario->id}}" type="radio" {{ (Input::old('epl_'.$scenario->id) == $entrypoint_line[0]) ? 'checked' : '' }}> {{ $entrypoint_line[0] }}</label></div>
                                            <div class="radio"><label><input value="{{ $entrypoint_line[1] }}" name="epl_{{$scenario->id}}" type="radio" {{ (Input::old('epl_'.$scenario->id) == $entrypoint_line[1]) ? 'checked' : '' }}> {{ $entrypoint_line[1] }}</label></div>
                                            <div class="radio"><label><input value="{{ $entrypoint_line[2] }}" name="epl_{{$scenario->id}}" type="radio" {{ (Input::old('epl_'.$scenario->id) == $entrypoint_line[2]) ? 'checked' : '' }}> {{ $entrypoint_line[2] }}</label></div>
                                              
                                        </div><!-- col-sm-8 -->
                                    </div><!-- form-group -->

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Choose stolen data:</label>
                                        <div class="col-sm-8">
                                            
                                            <div class="radio"><label><input value="{{ $stolen_data[0] }}" name="sd_{{$scenario->id}}" type="radio" {{ (Input::old('sd_'.$scenario->id) == $stolen_data[0]) ? 'checked' : '' }}> {{ $stolen_data[0] }}</label></div>
                                            <div class="radio"><label><input value="{{ $stolen_data[1] }}" name="sd_{{$scenario->id}}" type="radio" {{ (Input::old('sd_'.$scenario->id) == $stolen_data[1]) ? 'checked' : '' }}> {{ $stolen_data[1] }}</label></div>
                                            <div class="radio"><label><input value="{{ $stolen_data[2] }}" name="sd_{{$scenario->id}}" type="radio" {{ (Input::old('sd_'.$scenario->id) == $stolen_data[2]) ? 'checked' : '' }}> {{ $stolen_data[2] }}</label></div>
                                              
                                        </div><!-- col-sm-8 -->
                                    </div><!-- form-group -->

                                    </div>
                                </div>

                        @elseif ($scenario->type == "ddos")


                            <?php

                                $ip = array( 
                                    $scenario->attacker_ip, 
                                    $scenario->attacker_option1_ip, 
                                    $scenario->attacker_option2_ip 
                                    );

                                shuffle($ip);

                                $date = array(
                                    $scenario->attacker_date,
                                    $scenario->attacker_option1_date,
                                    $scenario->attacker_option2_date
                                    );

                                shuffle($date);

                            ?>

                            <div class="panel panel-warning">
                                 <div class="panel-heading">
                                        @if ($vmachine->console == '')
                                            <a href="/vmachine/console/{{$vmachine->id}}/{{$assignment->id}}">
                                              <button class="btn btn-primary pull-right" type="button">Request Console</button>
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
                                        <h3 class="panel-title">DDOS Scenario</h3>
                                    </div>

                                <div class="panel-body">

                                    <p class="text-info"><i class="glyphicon glyphicon-hdd"></i> <strong>Note:</strong> Use <strong>HD3</strong> Disk in X-Ways.</p>
                                    <p class="text-default"><strong>Description of attack:</strong>
                                        Several attackers performed a DDOS attack on the victom. Find the correct answers below.
                                    </p>
                                
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Choose correct attacker IP:</label>
                                        <div class="col-sm-8">
                                            
                                            <div class="radio"><label><input value="{{ $ip[0] }}" name="ip_{{$scenario->id}}" type="radio" {{ (Input::old('ip_'.$scenario->id) == $ip[0]) ? 'checked' : '' }}> {{ $ip[0] }}</label></div>
                                            <div class="radio"><label><input value="{{ $ip[1] }}" name="ip_{{$scenario->id}}" type="radio" {{ (Input::old('ip_'.$scenario->id) == $ip[1]) ? 'checked' : '' }}> {{ $ip[1] }}</label></div>
                                            <div class="radio"><label><input value="{{ $ip[2] }}" name="ip_{{$scenario->id}}" type="radio" {{ (Input::old('ip_'.$scenario->id) == $ip[2]) ? 'checked' : '' }}> {{ $ip[2] }}</label></div>
                                              
                                        </div><!-- col-sm-8 -->
                                    </div><!-- form-group -->

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Choose correct date of attack:</label>
                                        <div class="col-sm-8">
                                            
                                            <div class="radio"><label><input value="{{ $date[0] }}" name="date_{{$scenario->id}}" type="radio" {{ (Input::old('date_'.$scenario->id) == $date[0]) ? 'checked' : '' }}> {{ $date[0] }}</label></div>
                                            <div class="radio"><label><input value="{{ $date[1] }}" name="date_{{$scenario->id}}" type="radio" {{ (Input::old('date_'.$scenario->id) == $date[1]) ? 'checked' : '' }}> {{ $date[1] }}</label></div>
                                            <div class="radio"><label><input value="{{ $date[2] }}" name="date_{{$scenario->id}}" type="radio" {{ (Input::old('date_'.$scenario->id) == $date[2]) ? 'checked' : '' }}> {{ $date[2] }}</label></div>
                                              
                                        </div><!-- col-sm-8 -->
                                    </div><!-- form-group -->

                                </div>
                            </div>

                        @endif

                    @endforeach

                @endif

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