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
                    <li>Users</li>
                </ul>
                <h4>Users</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
    
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
        <div class="panel-heading">List of all Users</div>
            <div class="panel-body">
            
                <table id="basicTable" class="table table-striped table-bordered responsive">
            
                <a href="/users/new" class="btn btn-success pull-right" style="margin-left:10px; margin-top:3px"><i class="fa fa-user"></i> New user</a>

                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                
                <!-- {{-- @foreach ($users as $user) --}}
                <tr>
                    <td>{{-- $user->id --}}</td>
                    <td><a href="/users/profile/{{-- $user->id --}}">{{-- $user->email --}}</a></td>
                    <td>{{-- $user->first_name --}}</td>
                    <td>{{-- $user->last_name --}}</td>

                    <td>
                        <a href="/users/edit/{{-- $user->id --}}" class="btn btn-default btn-xs btn-icon icon-left"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="/users/delete/{{-- $user->id --}}" class="btn btn-danger btn-xs btn-icon icon-left"><i class="fa fa-times"></i> Delete</a>
                        <a href="/users/profile/{{-- $user->id --}}" class="btn btn-primary btn-xs btn-icon icon-left"><i class="fa fa-info"></i> Profile</a>
                    </td>
                </tr>
                 {{-- @endforeach --}}--->

                </table>
            </div>
    </div>

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop
