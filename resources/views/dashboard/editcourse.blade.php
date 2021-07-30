@extends('dashboard.master')

<script type="text/javascript">

function readURL(input) {
   if (input.files && input.files[0]) {
       var reader = new FileReader();
       reader.onload = function(e) {
           $('#preview').attr('src', e.target.result);
       }

       reader.readAsDataURL(input.files[0]);
   }
}
</script>

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
                    <li><a href="/courses">Courses</a></li>
                    <li>Edit course</li>
                </ul>
                <h4>Edit course</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">

        @if($errors->has())
            <div class="alert alert-danger">
            <button aria-hidden="true" class="close" type="button" data-dismiss="alert" type="button">×</button>

            @foreach ($errors->all() as $error)
            <ul>
                <li>{{ $error }}</li>
            </ul>
            @endforeach</div>
        @endif

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
            <div class="panel-heading">
                <h4 class="panel-title">Edit course details</h4>
                <p>Enter more detailed information about the course.</p>
            </div>

            {{Form::open(array('url'=>'/courses/edit/'.$course->id,'method'=>'post', 'files' => true, 'class'=>''))}}
            <div class="panel-body">

                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" name="name" placeholder="Enter course name" class="form-control" value="{{$course->name}}">
                            <span class="input-group-addon"><i class="fa fa-suitcase"></i></span>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group"><?php $phpdate = strtotime( $course->finish_at ); $enddate = date( 'm/d/Y', $phpdate ); ?>
                            <input type="text" name="finish" class="form-control" placeholder="mm/dd/yyyy" id="datepicker" value="{{$enddate}}">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                </div>

                <hr>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="{{ isset($preview->filename) ? '/uploads/courses/'.$preview->filename : '/images/default_course.jpg' }}" id="preview" class="thumbnail img-responsive" alt="">
                        </div>
                        <div class="col-sm-10">
                            <p>Course preview image:</p>
                            <div class="panel-body alert alert-info">
                                <input name="preview" multiple="1" type="file" onchange="readURL(this)"/>
                            </div><!-- panel-body -->
                        </div>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <div class="col-sm-12">
                        <textarea id="ckeditor" name="description" placeholder="" class="form-control" rows="8">{{$course->description}}</textarea>
                    </div>
                </div>

                <hr>

               <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-paperclip"></i> Attachments</h3>
                  </div>
                  <div class="panel-body">
                    <ul class="list-unstyled">
                    @foreach ($files as $file)
                         <li>
                            <i class="fa fa-file-text-o mr5"></i> <a href="/download/{{ $file->filename }}">{{$file->real_name}}</a> <small class="text-muted">{{round($file->size/1000).' KB'}}</small>
                            <a href="/delete/{{$file->filename}}"><i class="fa fa-trash-o"></i></a>
                         </li>
                    @endforeach
                    </ul>
                  </div>
                </div>
                <div class="form-group">
                    <p>Add new Attachments:</p>
                    <div class="panel-body alert alert-warning">
                        <input name="files[]" multiple="1" type="file" />
                    </div><!-- panel-body -->
                </div>


            <div class="panel-footer">
                <button type="submit" class="btn btn-primary mr5">Submit</button>
                <button class="btn btn-default" type="reset">Reset</button>
            </div><!-- panel-footer"-->
            {{Form::close()}}

        </div><!-- panel -->

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop


@section('scripts')

{{ HTML::script('js/ckeditor/ckeditor.js')}}
{{ HTML::script('js/ckeditor/adapters/jquery.js')}}
{{ HTML::script('js/bootstrap-datepicker.js') }}

<script type="text/javascript">
// CKEditor
jQuery('#ckeditor').ckeditor();


$('#datepicker').datepicker({
    todayHighlight: true
});
</script>
@stop