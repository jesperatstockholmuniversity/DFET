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
                    <li><a href="/"><i class="fa fa-pencil"></i></a></li>
                    <li><a href="/assignments">Assignments</a></li>
                    <li>New Assignment</li>
                </ul>
                <h4>New Assignment</h4>
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

            {{Form::open(array('url'=>'/assignments/new','method'=>'post', 'class'=>'panel-wizard'))}}
            <div class="panel panel-primary">
                <div class="panel-heading">New Assignment</div>
                    <div class="panel-body">
                        
                        <div class="form-group">
                            <label class="col-sm-4">Username</label>
                            <div class="col-sm-8">
                                <input class="name form-control" name="username" type="text" placeholder="Firstname or Lastname">
                            </div>
                        </div><!-- form-group -->
                        
                        
                        <div class="form-group">
                            <label class="col-sm-4">Course</label>
                            <div class="col-sm-8">
                                <select id="course" name="course" data-placeholder="Choose One" class="width100p form-control" required>
                                    <option value="">Choose One</option>
                                    @foreach ($courses as $course)
                                    <option value="{{$course->id}}">
                                        {{$course->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- form-group -->

                        <div class="form-group">
                            <label class="col-sm-4">Scenario</label>
                            <div class="col-sm-8">
                                <select id="scenario" name="scenario" data-placeholder="Choose One" class="width100p form-control" required>
                                    <option value="">Choose One</option>
                                    @foreach ($scenarios as $scenario)
                                    <option value="{{$scenario->id}}">
                                        {{$scenario->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- form-group -->
<!--
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Virtual Machine</label>
                            <div class="col-sm-8">
                                <select id="vmachine" name="vmachine" data-placeholder="Choose One" class="width100p" required>
                                    <option value="">Choose One</option>
                                    @foreach ($vmachines as $vmachine)
                                    <option value="{{$vmachine->id}}">
                                        {{$vmachine->machine_name}} / Scenarios: 
                                            @if ($vmachine->scenarios == 7)
                                                <span>Phishing, SQL, DDOS</span>
                                            @elseif ($vmachine->scenarios == 1) 
                                                <span>Phishing</span>
                                            @elseif ($vmachine->scenarios == 2) 
                                                <span>SQL</span>
                                            @elseif ($vmachine->scenarios == 3) 
                                                <span>Phishing, SQL</span>
                                            @elseif ($vmachine->scenarios == 4) 
                                                <span>DDOS</span>
                                            @elseif ($vmachine->scenarios == 5) 
                                                <span>Phishing, DDOS</span>
                                            @elseif ($vmachine->scenarios == 6) 
                                                <span>SQL, DDOS</span>
                                            @endif
                                    </option>
                                    @endforeach
                                </select>
                                <label class="error" for="group"></label>
                            </div>
                        </div> --><!-- form-group -->

                        <div class="form-group">
                            <label class="col-sm-4">Estimated Time (minutes)</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="time" type="text" placeholder="Enter Time">
                            </div>
                        </div><!-- form-group -->

                    </div><!-- panel body -->
                    <div class="panel-footer">
                        <button class="btn btn-primary mr5" id="submit_btn">Submit</button>
                    </div><!-- panel-footer"-->
            </div>
            {{Form::close()}} 

        </div><!-- end row -->

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->


@stop