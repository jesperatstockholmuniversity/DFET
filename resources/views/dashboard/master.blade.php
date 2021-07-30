<!DOCTYPE html>
<html>
    <head>
        <title>
            DFet - Dashboard
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        {{ Html::style('css/bootstrap.css') }}
        {{ Html::style('css/style.default.css') }}
        {{ Html::style('css/dataTables.responsive.css') }}
        {{ Html::style('css/dataTables.bootstrap.css') }}
        {{ Html::style('css/select2.css') }}
        {{ Html::style('css/style.calendar.css') }}
        {{ Html::style('css/datepicker3.css') }}

        {{ Html::script('js/doc-ready.js') }}
    </head>

    <body class="pace-done">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div style="background-color: #002e5f">
                        <a href="http://www.su.se/">
                            <img src="/images/SU_logo_NEG_ENGELSK.png" style="margin: 20px; min-width:112px; min-height: 102px; max-width:112px; max-height: 102px;">
                        </a>
                        <a href="http://www.d-fet.eu/">
                            <img src="/images/logo-dfet.png" style="margin: 20px; min-height: 80px; max-height: 80px;">
                        </a>
                    </div>
                </div>
            </div>
            
            <section>
                <!--<div class="mainwrapper">-->
                    <ul class="nav nav-tabs">
                        <li><a href="/"><i class="fa fa-home"></i> Dashboard</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fa fa-users"></i> Users <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/users"><i class="fa fa-users"></i> Users</a></li>
                                <li><a href="/users/new"><i class="fa fa-plus"></i> New user</a></li>
                            </ul>
                        </li>

                        @if(Sentinel::findById(2))
                            <li><a href="/calendar"><i class="fa fa-calendar"></i> Calendar</a></li>
                        @else 
                            <li><a href="/calendar/user"><i class="fa fa-calendar"></i> Calendar</a></li>
                        @endif

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                <i class="fa fa-suitcase"></i> Courses <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/courses"><i class="fa fa-suitcase"></i> Courses</a></li>
                                @if(Sentinel::findById(2))
                                    <li><a href="/courses/new"><i class="fa fa-plus"></i> New course</a></li>
                                    <li><a href="/courses/enroll"><i class="fa fa-user"></i> User enrollment</a></li>
                                @endif
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                <i class="glyphicon glyphicon-hdd"></i> Virtual Machines <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/vmachines"><i class="glyphicon glyphicon-hdd"></i> Virtual Machines</a></li>
                                <li><a href="/vmachines/new"><i class="fa fa-plus"></i> New Virtual</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                <i class="glyphicon glyphicon-tasks"></i> Scenarios <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/scenarios"><i class="glyphicon glyphicon-tasks"></i> Scenarios</a></li>
                                @if(Sentinel::findById(4))
                                    <li><a href="/scenarios/new"><i class="fa fa-plus"></i> New Scenario</a></li>
                                @endif
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                <i class="fa fa-edit"></i> Assignments <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/assignments"><i class="fa fa-edit"></i> Assignments</a></li>
                                @if(Sentinel::findById(4))
                                    <li><a href="/assignments/new"><i class="fa fa-plus"></i> New Assignment</a></li>
                                @endif
                            </ul>
                        </li>

                        <li class="dropdown pull-right">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                <i class="fa fa-user"></i> My Account <span class="caret"></span>
                            </a>
			    <ul class="dropdown-menu pull-right" role="menu">
				   @if (Session::has('user'))
					<div class="alert alert-success">
				        <p>{{ Session::get('user')}}</p>
					</div>
				   @endif
                              <li><a href="/users/profile/{{ Session::get('user') }}"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
                              <li><a href="/users/settings/{{ Session::get('user') }}"><i class="glyphicon glyphicon-cog"></i> Account Settings</a></li>
                              <li><a href="#"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                              <li class="divider"></li>
                              <li><a href="/logout"><i class="glyphicon glyphicon-log-out"></i> Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                    
                    <!-- Content -->
                    @yield('content')
                    
                <!--</div> mainwrapper -->
            </section>
        </div>

        {{ Html::script('js/jquery-1.11.1.min.js') }}
        {{ Html::script('js/bootstrap.min.js') }}
        
        {{ Html::script('js/custom.js')}}
        {{ Html::script('js/dashboard.js')}}
        {{ Html::script('js/alert.js')}}
        {{ Html::script('js/select2.js')}}
        {{ Html::script('js/moment.min.js')}}

        {{ Html::script('js/jquery.dataTables.min.js')}}
        {{ Html::script('js/dataTables.bootstrap.js')}}
        {{ Html::script('js/dataTables.responsive.js')}}

        {{ Html::script('js/typeahead.js')}}

        <!-- View Scripts -->
        @yield('scripts')

        <script>
            jQuery(document).ready(function(){

                // Remove active for all items.
                $('.page-sidebar-menu li').removeClass('active');
                // highlight submenu item
                $('li a[href="' + this.location.pathname + '"]').parent().addClass('active');
                // Highlight parent menu item.
                $('ul a[href="' + this.location.pathname + '"]').parents('li').addClass('active');
                
                jQuery('#basicTable').DataTable({
                    responsive: true
                });
                
                // Validation with select boxes
                jQuery("#activated, #group, #status, #vmachine, #permission").select2({
                    minimumResultsForSearch: -1
                });

                var users = new Bloodhound({
                  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                  queryTokenizer: Bloodhound.tokenizers.whitespace,
                  remote: '/search/user/%QUERY'
                });

                var courses = new Bloodhound({
                  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('course'),
                  queryTokenizer: Bloodhound.tokenizers.whitespace,
                  remote: '/search/course/%QUERY'
                });
                 
                users.initialize();
                courses.initialize();
                 
                $('.name').typeahead(null, {
                  name: 'users',
                  displayKey: 'name',
                  source: users.ttAdapter()
                });

                $('.course').typeahead(null, {
                  name: 'courses',
                  displayKey: 'course',
                  source: courses.ttAdapter()
                });

                $(document).ready(function() {

                  // Match to Bootstraps data-toggle for the modal
                  // and attach an onclick event handler
                  $('a[data-toggle="modal"]').on('click', function(e) {

                    // From the clicked element, get the data-target arrtibute
                    // which BS3 uses to determine the target modal
                    var target_modal = $(e.currentTarget).data('target');
                    // also get the remote content's URL
                    var remote_content = e.currentTarget.href;

                    // Find the target modal in the DOM
                    var modal = $(target_modal);
                    // Find the modal's <div class="modal-body"> so we can populate it
                    var modalBody = $(target_modal + ' .modal-body');

                    // Capture BS3's show.bs.modal which is fires
                    // immediately when, you guessed it, the show instance method
                    // for the modal is called
                    modal.on('show.bs.modal', function () {
                            // use your remote content URL to load the modal body
                            modalBody.load(remote_content);
                        }).modal();
                        // and show the modal

                    // Now return a false (negating the link action) to prevent Bootstrap's JS 3.1.1
                    // from throwing a 'preventDefault' error due to us overriding the anchor usage.
                    return false;
                  });
                });
            });
        </script>
        <div class="modal fade" id="serverLog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Server log</h4>
              </div>
              <div class="modal-body">
              </div>
            </div>
          </div>
        </div>
    </body>
</html>
