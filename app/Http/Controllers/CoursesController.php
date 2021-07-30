<?php
namespace App\Http\Controllers;
use App\Models\Course as Course;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
//use App\Models\Course;

class CoursesController extends Controller {
	public function __construct()
	{
		//$this->beforeFilter('csrf', $array('on' => 'post'));
	}

	public function showCourses()
	{

		$courses = Course::all();
		$view = view('dashboard/courses');
		$view->with('courses',$courses);

		return $view;
	}

	public function newEnrollment(){

		$users = User::all(array('first_name'));

		$view = view('dashboard/newenrollment');
		$view->with('users',$users);

		return $view;
	}

	public function storeEnrollment()
	{
		$input = Input::all();

		$name = explode(" ", trim($input['username']));

		$user = User::select ('id')
        					->where('first_name', 'LIKE', $name[0] . '%')
        					->orWhere('last_name', 'LIKE', $name[1] . '%')
        					->first();

		$course = Course::select ('id')
        					->where('name', 'LIKE', $input['course'] . '%')
        					->first();

        $enrolled = Enrollment::where('user_id',$user->id)->first();
        if(!isset($enrolled))
		{
			$enrollment = new Enrollment;
			$enrollment->user_id = $user->id;
			$enrollment->course_id = $course->id;
			$enrollment->status = $input['status'];
			$enrollment->save();
			Session::flash('success_msg', 'You have successfully enrolled '.$input['username'].' on '.$input['course'].' course.');
			return Redirect::to('/courses/view/'.$course->id);
		} else {
			Session::flash('error_msg', 'You have already enrolled '.$input['username'].' on '.$input['course'].' course.');
			return Redirect::to('/courses/enroll');
		}

	}

	public function enrollCourse($courseId)
	{
		$enrolled = Enrollment::where('user_id',Sentinel::getUser()->id)->first();

		if(!isset($enrolled))
		{
			$enrollment = new Enrollment;
			$enrollment->user_id = Sentinel::getUser()->id;
			$enrollment->course_id = $courseId;
			$enrollment->status = 'inreview';
			$enrollment->save();
			Session::flash('success_msg', 'You have successfully enrolled on selected course. Please wait for your enrollment confirmation.');
			return Redirect::to('/courses/list');
		} else {
			Session::flash('error_msg', 'You have already enrolled for this course. Please wait for your enrollment confirmation.');
			return Redirect::to('/courses/list');
		}
	}

	public function enrollUser($courseId,$userId)
	{
		$enrollment = Enrollment::where('course_id',$courseId)->where('user_id', $userId)->first();
		$enrollment->status = 'active';
		$enrollment->save();

		Session::flash('success_msg', 'User was successfully enrolled to course.');
		return Redirect::to('/courses/view/'.$courseId);

	}

	public function remove($courseId,$userId)
	{
		$enrollment = Enrollment::where('course_id',$courseId)->where('user_id', $userId)->delete();

		Session::flash('success_msg', 'User was successfully removed from course.');
		return Redirect::to('/courses/view/'.$courseId);

	}

	public function reviewUser($courseId,$userId)
	{
		$enrollment = Enrollment::where('course_id',$courseId)->where('user_id', $userId)->first();
		$enrollment->status = 'inreview';
		$enrollment->save();

		Session::flash('success_msg', 'User is now in review mode.');
		return Redirect::to('/courses/view/'.$courseId);

	}

	public function deleteCourse($id)
	{
		Course::find($id)->delete();

		$files = Files::where('course_id', $id)->get();
		Enrollment::where('course_id', $id)->delete();
		    
	    foreach ($files as $file) 
	    {
    		File::delete($file->path.$file->filename);
    		$file->delete();
	    }

		Session::flash('success_msg', 'Course successfully deleted.');
		return Redirect::to('/courses');
	}

	public function newCourse()
	{
		$view = view('dashboard/newcourse');

		return $view;
	}

	public function showCourse($id)
	{
		$course = Course::find($id);
		$user = Sentinel::findUserById($course->user_id);
		$files = Files::where('course_id', $course->id)
						->where('type', 'attachment')
						->get();

		$avatar = Files::where('user_id', $user->id)
		    			->where('type', 'avatar')
		    			->first();

		$preview = Files::where('course_id', $id)
						->where('type', 'course')
						->first();

		$enrollments = Enrollment::select(array(
						        'enrollment.id',
						        'enrollment.user_id',
						        'enrollment.created_at',
						        'enrollment.status',
						        'users.id AS user_id',
						        'users.first_name',
						        'users.last_name',
						        'users.email'
						    ))
							->leftJoin('users', function($join) {
								$join->on('enrollment.user_id', '=', 'users.id');
							})
							->where('enrollment.course_id',$id)
							->paginate(5);

		$view = view('dashboard/course');
		
		$view->with('course',$course)
			 ->with('user', $user)
			 ->with('files', $files)
			 ->with('avatar', $avatar)
			 ->with('enrollments', $enrollments)
			 ->with('preview', $preview);

		return $view;
	}

	public function editCourse($id)
	{
		$course = Course::find($id);
		$user = Sentinel::findUserById($course->user_id);
		$files = Files::where('course_id', $course->id)
						->where('type', 'attachment')
						->get();

		$preview = Files::where('course_id', $id)
						->where('type', 'course')
						->first();

		$view = view('dashboard/editcourse');
		
		$view->with('course',$course)
			 ->with('user', $user)
			 ->with('files', $files)
			 ->with('preview', $preview);

		return $view;
	}

	public function updateCourse($id)
	{
		$input = Input::all();
	    $all_uploads = Input::file('files');

	    $validator = \Validator::make($input, Course::$update_rules);

	    if ($validator->fails()) {
	        return Redirect::to('/courses/edit/'.$id)
	                       ->withErrors($validator)
	                       ->withInput(Input::except('files'));
	    } else {

	    	$finish = explode("/", $input['finish']);
	    	$finish = $finish[2].'-'.$finish[0].'-'.$finish[1];
	    	//dd($finish);

	    	$course = Course::where('id', $id)->first();
		$course->name        = $input['name'];
	        $course->description = $input['description'];
	        $course->finish_at	 = $finish;
	        $course->save();

            if ($all_uploads[0] != NULL) {

            	// Make sure it really is an array
			    if (!is_array($all_uploads)) {
			        $all_uploads = array($all_uploads);
			    }

			    // Loop through all uploaded files
			    foreach ($all_uploads as $upload) {

			        $validator = Validator::make(
			            array('file' => $upload),
			            array('file' => 'mimes:png,gif,jpeg,txt,pdf,doc,docx,rtf,mov|max:20000')
			        );

			        if ($validator->passes()) {
			            // Do something

			        	$fname = $upload->getClientOriginalName();
	                    $size  = $upload->getSize();

	                    $destinationPath = public_path() . '/uploads';

	                    $filename = str_random(12);

	                    $upload_success = $upload->move($destinationPath, $filename);

	                    if ($upload_success) {
	                        $file            = new Files;
	                        $file->filename  = $filename;
	                        $file->real_name = $fname;
	                        $file->size      = $size;
	                        $file->user_id   = Sentinel::getUser()->id;
	                        $file->course_id = $course->id;
	                        $file->type 	 = "attachment";
	                        $file->path 	 = public_path().'/uploads/';
	                        $file->save();
	                    }
			        } else {
			        	Course::where('id', $course->id)->delete();
			        	return Redirect::to('/courses/edit/'.$id)
	                       ->withErrors($validator)
	                       ->withInput(Input::except('files'));
			        } 
			    }
			}

			if(Input::hasFile('preview')) {

				$old_preview = Files::where('course_id', $id)
						->where('type', 'course')
						->first();

				if($old_preview != NULL) {
					File::delete($old_preview->path.$old_preview->filename);
					$old_preview->delete();
				}

				$preview = Input::file('preview');
				$fname = $preview->getClientOriginalName();
                $size  = $preview->getSize();

                $destinationPath = public_path() . '/uploads/courses';

                $filename = str_random(12);

                $upload_success = $preview->move($destinationPath, $filename);

                if ($upload_success) {
                    $file            = new Files;
                    $file->filename  = $filename;
                    $file->real_name = $fname;
                    $file->size      = $size;
                    $file->user_id   = Sentinel::getUser()->id;
                    $file->course_id = $course->id;
                    $file->type 	 = "course";
                    $file->path 	 = public_path().'/uploads/courses/';
                    $file->save();
                }
			}

			Session::flash('success_msg', 'Course was successfully updated.');

			return Redirect::to('/courses/edit/'.$id); 
	    }
	}

	public function viewCourse($id)
	{
		$course = Course::find($id);
		$user = Sentinel::findUserById($course->user_id);
		$files = Files::where('course_id', $course->id)
						->where('type', 'attachment')
						->get();

		$enrollment = Enrollment::select('id')
								->where('user_id',Sentinel::getUser()->id)
								->where('course_id', $id)
								->first();

		$assignments = Assignment::where('enrollment_id',$enrollment->id)
								->where('course_id', $id)
								->get();

		$view = view('dashboard/courseview');

		$view->with('course',$course)
			 ->with('user', $user)
			 ->with('files', $files)
			 ->with('assignments', $assignments);
		
		return $view;
	}

	public function listCourses()
	{
		$courses = Course::listCourses();

		$view = view('dashboard/courseslist');
		$view->with('courses',$courses);

		return $view;
	}

	public function storeCourse() 
	{
	    $input = Input::all();
	    $all_uploads = Input::file('files');

	    $validator = \Validator::make($input, Course::$rules);

	    if ($validator->fails()) {
	        return Redirect::to('/courses/new')
	                       ->withErrors($validator)
	                       ->withInput(Input::except('files'));
	    } else {

	    	$finish = explode("/", $input['finish']);
	    	$finish = $finish[2].'-'.$finish[0].'-'.$finish[1];
	    	//dd($finish);

	    	$course 			 = new Course;
		    $course->name        = $input['name'];
	        $course->description = $input['description'];
	        $course->user_id     = Sentinel::getUser()->id;
	        $course->finish_at	 = $finish;
	        $course->save();

            if ($all_uploads[0] != NULL) {

            	// Make sure it really is an array
			    if (!is_array($all_uploads)) {
			        $all_uploads = array($all_uploads);
			    }

			    // Loop through all uploaded files
			    foreach ($all_uploads as $upload) {

			        $validator = Validator::make(
			            array('file' => $upload),
			            array('file' => 'mimes:png,gif,jpeg,txt,pdf,doc,docx,rtf,mov|max:20000')
			        );

			        if ($validator->passes()) {
			            // Do something

			        	$fname = $upload->getClientOriginalName();
	                    $size  = $upload->getSize();

	                    $destinationPath = public_path() . '/uploads';

	                    $filename = str_random(12);

	                    $upload_success = $upload->move($destinationPath, $filename);

	                    if ($upload_success) {
	                        $file            = new Files;
	                        $file->filename  = $filename;
	                        $file->real_name = $fname;
	                        $file->size      = $size;
	                        $file->user_id   = Sentinel::getUser()->id;
	                        $file->course_id = $course->id;
	                        $file->type 	 = "attachment";
	                        $file->path 	 = public_path().'/uploads/';
	                        $file->save();
	                    }
			        } else {
			        	Course::where('id', $course->id)->delete();
			        	return Redirect::to('/courses/new')
	                       ->withErrors($validator)
	                       ->withInput(Input::except('files'));
			        } 
			    }
			}

			if(Input::hasFile('preview')) {
				$preview = Input::file('preview');
				$fname = $preview->getClientOriginalName();
                $size  = $preview->getSize();

                $destinationPath = public_path() . '/uploads/courses';

                $filename = str_random(12);

                $upload_success = $preview->move($destinationPath, $filename);

                if ($upload_success) {
                    $file            = new Files;
                    $file->filename  = $filename;
                    $file->real_name = $fname;
                    $file->size      = $size;
                    $file->user_id   = Sentinel::getUser()->id;
                    $file->course_id = $course->id;
                    $file->type 	 = "course";
                    $file->path 	 = public_path().'/uploads/courses/';
                    $file->save();
                }
			}

			Session::flash('success_msg', 'Course was successfully created.');

			return Redirect::to('/courses'); 
	    }
	}

	public function downloadAttachment($filename)
	{
		$file = Files::where('filename', $filename)->first();
		//dd($file->path.$name);
		return Response::download($file->path.$filename, $file->real_name);
	}

	public function deleteAttachment($filename)
	{
		$file = Files::where('filename', $filename)->first();
		$filename = $file->real_name;
		if($file != NULL) {
			File::delete($file->path.$file->filename);
			$file->delete();
		} 
		Session::flash('success_msg', 'Your file '.$filename.' was successfully deleted');
		return Redirect::back();
	}

}
