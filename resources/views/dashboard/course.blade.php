@extends('dashboard.master')

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-suitcase"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="fa fa-suitcase"></i></a></li>
                    <li><a href="/courses">Courses</a>
                    <li>Course: {{$course->name}}</li>
                </ul>
                <h4>Course: {{$course->name}}</h4>
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

    		<div class="panel-group panel-group-msg" id="accordion">
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <span class="time text-muted pull-right"><i class="fa fa-paperclip mr5"></i> 
                                <span class="label label-success">Created: {{ Carbon::createFromTimestamp(strtotime($course->created_at))->diffForHumans() }}</span>
                                <span class="label label-warning">Ends in: {{ Carbon::createFromTimestamp(strtotime($course->finish_at))->diffForHumans() }}</span>
                            </span>
                            <a data-toggle="collapse" href="#collapseOne">
                                <i class="fa fa-suitcase"></i> </i> Course: {{$course->name}}
                            </a>
                        </h4>
                    </div>
                    
                    <div id="collapseOne" class="panel-collapse collapse in">
                        
                        <div class="panel-body">

                            <div class="panel panel-success">
                              <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-file-text"></i> Description</h3>
                              </div>
                              <div class="panel-body">
                                <div class="media">
                                  <a class="pull-left" href="#">
                                    <img class="media-object thumbnail" style="width:250px" src="{{ isset($preview->filename) ? '/uploads/courses/'.$preview->filename : '/images/default_course.jpg' }}" alt="course">
                                  </a>
                                  <div class="media-body">
                                    {{ $course->description }}
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-paperclip"></i> Attachments</h3>
                              </div>
                              <div class="panel-body">
                                <ul class="list-unstyled">
                                @foreach ($files as $file)
                                     <li><i class="fa fa-file-text-o mr5"></i> <a href="/download/{{ $file->filename }}">{{$file->real_name}}</a> <small class="text-muted">{{round($file->size/1000).' KB'}}</small></li>
                                @endforeach
                                </ul>
                              </div>
                            </div>

                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-users"></i> Enrollments</h3>
                              </div>
            
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Enrolled</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($enrollments as $enrollment)
                                  <tr>
                                    <td>{{ $enrollment->id }}</td>
                                    <td>{{ $enrollment->first_name }}</td>
                                    <td>{{ $enrollment->last_name }}</td>
                                    <td>{{ $enrollment->email }}</td>
                                    <td><span class="label label-success">{{ Carbon::createFromTimestamp(strtotime($enrollment->created_at))->diffForHumans() }}</span></td>

                                    @if ($enrollment->status == 'inreview')
                                      <td><span class="label label-warning">{{ $enrollment->status }}</span></td>
                                    @elseif ($enrollment->status == 'active')
                                      <td><span class="label label-success">{{ $enrollment->status }}</span></td>
                                    @elseif ($enrollment->status == 'finished')
                                      <td><span class="label label-danger">{{ $enrollment->status }}</span></td>
                                    @endif

                                    @if ($enrollment->status == 'inreview')
                                      <td>
                                        <a href="/courses/{{$course->id}}/enroll/{{$enrollment->user_id}}" class="btn btn-success btn-xs btn-icon icon-left"><i class="fa fa-check"></i> Approve user</a>
                                        <!-- todo remove assignements -->
                                        <a href="/courses/{{$course->id}}/remove/{{$enrollment->user_id}}" class="btn btn-danger btn-xs btn-icon icon-left"><i class="fa fa-times"></i> Remove user</a>
                                      </td>
                                    @elseif ($enrollment->status == 'active')
                                      <td>
                                        <a href="/courses/{{$course->id}}/review/{{$enrollment->user_id}}" class="btn btn-warning btn-xs btn-icon icon-left"><i class="fa fa-check"></i> Inreview user</a>
                                        
                                        <!-- todo remove assignements -->
                                        <a href="/courses/{{$course->id}}/remove/{{$enrollment->user_id}}" class="btn btn-danger btn-xs btn-icon icon-left"><i class="fa fa-times"></i> Remove user</a>

                                        <a href="/assignments/new/{{$enrollment->id}}/{{$user->id}}" class="btn btn-primary btn-xs btn-icon icon-left"><i class="fa fa-times"></i> New Assignment</a>
                                      </td>
                                    @elseif ($enrollment->status == 'finished')
                                      <td>
                                        <!-- todo remove assignements -->
                                        <a href="/courses/{{$course->id}}/remove/{{$enrollment->user_id}}" class="btn btn-danger btn-xs btn-icon icon-left"><i class="fa fa-times"></i> Remove user</a>
                                      </td>
                                    @endif

                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>

                              <span class="pull-right">{{ $enrollments->links() }}</span>

                            </div><!-- panel-warning end -->

                        </div><!-- panel body end -->
                    
                        <div class="panel-footer"> 
                            <div class="pull-left">
                                <div class="btn-group mr5">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                      <li><a href="/users/new">Add user</a></li>
                                      <li><a href="/courses/enroll">Enroll user</a></li>
                                      <li role="presentation" class="divider"></li>
                                      <li><a href="/vmachines">New virtual machine</a></li> 
                                    </ul>
                                  </div>
                            </div>

                            <div class="pull-right">
                            <img src="{{ isset($avatar->filename) ? '/uploads/avatars/'.$avatar->filename : '/images/default_avatar.png' }}" class="img img-online img-circle mr5" alt="">
                            {{$user->first_name.' '.$user->last_name}}
                            </div>
                        </div><!-- panel footer end -->

                    </div><!-- panel-collapse end -->

                </div><!-- panel-default end -->

    	   </div><!-- end accordian -->

       </div><!-- end row -->
       
     </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop