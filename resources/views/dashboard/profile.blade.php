@extends('dashboard.master')

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-users"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="glyphicon glyphicon-user"></i></a></li>
                    <li><a href="/users">Users</a></li>
                    <li>User profile</li>
                </ul>
                <h4>User profile: {{$user->first_name.' '.$user->last_name}}</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
	    
	    <div class="row">
	  		<div class="col-sm-4 col-md-4"><!--left col-->
	  		
	  		   <div class="text-center span3 well">
              <img src="{{ isset($avatar->filename) ? '/uploads/avatars/'.$avatar->filename : '/images/default_avatar.png' }}" class="img-circle img-offline img-responsive img-profile" alt="">
              <h4 class="profile-name mb5">{{$user->first_name.' '.$user->last_name}}</h4>
              <div><i class="fa fa-home"></i> {{$profile->address or "No address" }}</div>
              <div><i class="fa fa-briefcase"></i> {{$profile->organization or "No organization"}} </div>
            </div>
	              
	          <ul class="list-group">
	            <li class="list-group-item text-muted">Profile</li>
	            <li class="list-group-item text-right"><span class="pull-left"><strong>Joined</strong></span> {{ Carbon::createFromTimestamp(strtotime($user->created_at))->diffForHumans() }}</li>
	            <li class="list-group-item text-right"><span class="pull-left"><strong>Last seen</strong></span> {{ Carbon::createFromTimestamp(strtotime($user->last_login))->diffForHumans() }}</li>
	            <li class="list-group-item text-right"><span class="pull-left"><strong>Email</strong></span> {{$user->email}}</li>
	            
	          </ul>
	          
	          
	          <ul class="list-group">
	            <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
	            <li class="list-group-item text-right"><span class="pull-left"><strong>Courses</strong></span> {{$courses->count()}}</li>
	            <li class="list-group-item text-right"><span class="pull-left"><strong>Assignments</strong></span> {{$assignments->count()}}</li>
	            <li class="list-group-item text-right"><span class="pull-left"><strong>Virtual Machines</strong></span> {{$vmachines->count()}}</li>
	          </ul> 
	          
	        </div><!-- col-sm-4 col-md-3 -->
	    
	    <div class="col-sm-8 col-md-8">
          
          <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#courses" data-toggle="tab">Courses</a></li>
            <li><a href="#assignements" data-toggle="tab">Assignements</a></li>
            @if(Sentry::getUser()->hasAccess('admin'))
              <li><a href="#vmachines" data-toggle="tab">Virtual Machines</a></li>
            @endif
          </ul>
          
          <div class="tab-content">
            <div class="tab-pane active" id="courses">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Course</th>
                      <th>Status</th>
                      <th>Enrolled on</th>
                      @if(Sentry::getUser()->hasAccess('admin'))
                        <th>Actions</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody id="items">
                    @foreach ($courses as $course)
                    <tr>
                      <td>{{$course->id}}</td>
                      <td>{{$course->name}}</td>
                      <td>{{$course->status}}</td>
                      <td>{{ Carbon::createFromTimestamp(strtotime($course->created_at))->diffForHumans() }}</td>
                      @if(Sentry::getUser()->hasAccess('admin'))
                        <td><a href="/courses/view/{{$course->id}}" class="btn btn-info btn-xs btn-icon icon-left"><i class="fa fa-info-circle"></i> View</a></td>
                      @endif
                    </tr>
                  </tbody>
                  @endforeach
                </table>
                <hr>
                <div class="row">
                  <div class="col-md-4 col-md-offset-4 text-center">
                  	<ul class="pagination" id="myPager"></ul>
                  </div>
                </div>
              </div><!--/table-resp-->
              
              
             </div><!--/tab-pane-->
             

			     <div class="tab-pane" id="assignements">
             <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Course</th>
                      <th>Status</th>
                      <th>Created</th>
                      <th>Started</th>
                      <th>Finished</th>
                      <th>Percent</th>
                      @if(Sentry::getUser()->hasAccess('admin'))
                        <th>Actions</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody id="items">
                    @foreach ($assignments as $assignment)
                      <tr>
                          <td>{{ $assignment->id }}</td>
                          <td>{{ $assignment->name }}</td>
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
                          @if(Sentry::getUser()->hasAccess('admin'))
                            <td>
                                <a href="/assignments/delete/{{$assignment->id}}" class="btn btn-danger btn-xs btn-icon icon-left"><i class="fa fa-times"></i> Delete</a>
                                <a href="/assignments/view/{{$assignment->id}}" class="btn btn-info btn-xs btn-icon icon-left"><i class="fa fa-pencil"></i> View</a>
                            </td>
                          @endif
                      </tr>
                      @endforeach
                  </tbody>
                </table>
                <hr>
                <div class="row">
                  <div class="col-md-4 col-md-offset-4 text-center">
                  	<ul class="pagination" id="myPager"></ul>
                  </div>
                </div>
              </div><!--/table-resp-->
                             
             </div><!--/tab-pane-->
             
             @if(Sentry::getUser()->hasAccess('admin'))
             <div class="tab-pane" id="vmachines">
             <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Course</th>
                      <th>Machine</th>
                      <th>Created</th>
                      <th>Scenarios</th>
                      @if(Sentry::getUser()->hasAccess('admin'))
                        <th>Actions</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody id="items">
                    @foreach ($vmachines as $vmachine)
                    <tr>
                      <td>{{ $vmachine->id }}</td>
                      <td>{{ $vmachine->name }}</td>
                      <td>{{ $vmachine->machine_id.' / '.$vmachine->machine_name }}</td>

                      <td><span class="label label-success">{{ Carbon::createFromTimestamp(strtotime($vmachine->created_at))->diffForHumans() }}</span>
                      </td>

                      <td> 
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

                      </td>
                      
                      <td style="width:20%">
                        <div class="btn-group mr5">
                            <button type="button" class="btn btn-xs btn-default">Action</button>
                            <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <!--li><a href="/vmachines/view/{{$vmachine->id}}">View</a></li-->
                              <li><a href="/vmachine/{{$vmachine->id}}/operation/poweron">Power On</a></li>
                              <li><a href="/vmachine/{{$vmachine->id}}/operation/reset">Reboot</a></li>
                              <li><a href="/vmachine/{{$vmachine->id}}/operation/shutdown">Shutdown</a></li>
                              <li><a href="/vmachine/{{$vmachine->id}}/operation/poweroff">Power Off</a></li>
                              <li class="divider"></li>
                              <li><a href="/vmachine/{{$vmachine->id}}/operation/delete">Pyhisical Delete</a></li>
                              <li><a href="/vmachines/delete/{{$vmachine->id}}">Delete</a></li>
                            </ul>
                          </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <hr>
                <div class="row">
                  <div class="col-md-4 col-md-offset-4 text-center">
                  	<ul class="pagination" id="myPager"></ul>
                  </div>
                </div>
              </div><!--/table-resp-->
                             
             </div><!--/tab-pane-->
             @endif
             
            
          </div><!--/tab-content-->
          
	    
	</div>

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop