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

                            <div class="panel panel-default">
                              <div class="panel-heading">List of all Assignments</div>
                                  <div class="panel-body">

                                      <table class="table">

                                          <thead class="">
                                              <tr>
                                                <th>#</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Started</th>
                                                <th>Finished/Solved</th>
                                                <th>Percent</th>
                                                <th>Actions</th>
                                            </tr>
                                          </thead>

                                          @foreach ($assignments as $assignment)
                                          <tr>
                                              <td>{{ $assignment->id }}</td>
                                              <td>
                                                @if ($assignment->status == "created")
                                                  <span class="label label-success">Available</span>
                                                @elseif ($assignment->status == "open")
                                                  <span class="label label-info">Opened</span>
                                                @elseif ($assignment->status == "finished")
                                                  <span class="label label-danger">Finished</span>
                                                @elseif ($assignment->status == "finishedentry")
                                                  <span class="label label-info">Time exceeded</span>
                                                @endif
                                              </td>

                                              <td>
                                                <span class="label label-success">{{ Carbon::createFromTimestamp(strtotime($assignment->date_created))->diffForHumans() }}</span>
                                              </td>
                                              <td>
                                                <span class="label label-warning">
                                                  {{ ($assignment->date_started == NULL) ? "Not yet" : Carbon::createFromTimestamp(strtotime($assignment->date_started))->diffForHumans() }}</span>
                                              </td>
                                              <td>
                                                <span class="label label-warning">
                                                  {{ ($assignment->date_finished == NULL) ? "Not yet" : Carbon::createFromTimestamp(strtotime($assignment->date_finished))->diffForHumans() }}</span>
                                              </td>

                                              <td>
                                                <span class="label label-default">{{$assignment->percent or "0"}} %</span>
                                              </td>

                                              <td> 
                                                  @if ($assignment->date_started == NULL )
                                                    <a href="/assignments/take/{{$assignment->id}}" class="btn btn-info btn-xs btn-icon icon-left"><i class="fa fa-pencil"></i> Start Exam</a>
                                                  @elseif ($assignment->date_finished != NULL) 
                                                    <a href="#" class="btn btn-danger btn-xs btn-icon icon-left"><i class="fa fa-pencil"></i> Finished</a>
                                                  @elseif ($assignment->status == "open")
                                                    <a href="/assignments/take/{{$assignment->id}}" class="btn btn-info btn-xs btn-icon icon-left"><i class="fa fa-pencil"></i> Open Exam</a>
                                                  @endif
                                                  </a>
                                              </td>
                                          </tr>
                                          @endforeach

                                      </table>
                                  </div>
                            </div>

                        </div><!-- panel body end -->
                    
                        <div class="panel-footer"> 
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