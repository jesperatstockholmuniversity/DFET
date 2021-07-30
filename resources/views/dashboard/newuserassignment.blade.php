@extends('dashboard.master')

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-circle-o"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="fa fa-circle-o"></i></a></li>
                    <li><a href="/assignments">Assignments</a></li>
                    <li>New Assignment</li>
                </ul>
                <h4>New Assignment</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

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

    <div class="contentpanel">

    {{Form::open(array('url'=>'/assignments/create','method'=>'post', 'class'=>'panel-wizard'))}}
    <div class="panel panel-primary">
        <div class="panel-heading">New Virtual Machine</div>
            <div class="panel-body">
                
                <div class="form-group">
                    <label class="col-sm-4">User</label>
                    <div class="col-sm-8">
                        <input class="name form-control" name="username" type="text" value="{{$enrollment->first_name.' '.$enrollment->last_name}}" disabled>
                    </div>

                    <input name="enrollId" type="hidden" value="{{$enrollment->id}}">
                </div><!-- form-group -->

                <div class="form-group">
                    <label class="col-sm-4">Course Name</label>
                    <div class="col-sm-8">
                        <input class="name form-control" name="course" type="text" value="{{$enrollment->name}}" disabled>
                    </div>
                </div><!-- form-group -->

                <input name="courseId" type="hidden" value="{{$enrollment->course_id}}">

                <div class="form-group">
                    <label class="col-sm-4">Teacher</label>
                    <div class="col-sm-8">
                        <input class="name form-control" name="username" type="text" value="{{$teacher->first_name.' '.$teacher->last_name}}" disabled>
                    </div>

                    <input name="teacherId" type="hidden" value="{{$teacher->id}}">
                </div><!-- form-group -->

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
                </div><!-- form-group -->

                <div class="form-group">
                    <label class="col-sm-4">Estimated Time (minutes)</label>
                    <div class="col-sm-8">
                        <input class="name form-control" name="time" type="text" placeholder="Enter Time">
                    </div>
                </div><!-- form-group -->

            </div><!-- panel body -->
            <div class="panel-footer">
                <button class="btn btn-primary mr5" id="submit_btn">Submit</button>
            </div><!-- panel-footer"-->
    </div>
    {{Form::close()}} 

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->


@stop