@extends('dashboard.master')

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="glyphicon glyphicon-hdd"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="glyphicon glyphicon-hdd"></i></a></li>
                    <li>Virtual Machines</li>
                </ul>
                <h4>Virtual Machines</h4>
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

            <div class="panel panel-default">
                <div class="panel-heading"><i class="glyphicon glyphicon-hdd"></i> List of all Virtual Machines</div>
                    <div class="panel-body">

                        <table id="basicTable" class="table table-striped table-bordered responsive">

                        <a href="/vmachines/new" class="btn btn-success pull-right" style="margin-left:10px; margin-top:3px"><i class="glyphicon glyphicon-hdd"></i> New virtual</a>

                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Course</th>
                                    <th>Machine ID</th>
                                    <th>Machine Name</th>
                                    <th>Usage</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Scenarios</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            @foreach ($vmachines as $vmachine)
                            <tr>
                                <td>{{ $vmachine->id }}</td>
                                <td>{{ $vmachine->name }}</td>
                                <td>{{ $vmachine->machine_id }}</td>
                                <td>{{ $vmachine->machine_name }}</td>
                                <td>{{ ($vmachine->used == 1) ? '<span class="label label-danger">Used</span>' : '<span class="label label-success">Not used</span>' }}</td>
                                <td>
                                    @if ($vmachine->status == 0)
                                        <span class="label label-warning">Turned off</span>
                                    @elseif ($vmachine->status == 1) 
                                        <span class="label label-success">Running</span>
                                    @elseif ($vmachine->status == 2) 
                                        <span class="label label-warning">Turned off</span>
                                    @elseif ($vmachine->status == 3) 
                                        <span class="label label-danger">Physical deleted</span>
                                    @endif
                                </td>

                                <td><span class="label label-success">{{-- Carbon::createFromTimestamp(strtotime($vmachine->created_at))->diffForHumans() --}} {{ time() }}</span>
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

                                <td>
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

                        </table>
                    </div>
            </div>

        </div>

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop
