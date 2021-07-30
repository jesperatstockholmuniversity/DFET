<?php

namespace App\Http\Controllers;
use App\Http\Controllers;
use App\Models\User as User;
use App\Models\Course as Course;
use App\Models\Profile as Profile;
use App\Models\Assignment as Assignment;
use App\Models\VMachines as VMachines;
use App\Models\Files as Files;
use App\Models\Enrollment as Enrollment;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller {

	public function __construct()
	{
		//$this->beforeFilter('csrf', $array('on' => 'post'));
	}

	public function dashboard()
	{
		$courses = Course::all()->count();
		$view = view('dashboard/index');
		$user_id = Session::get('user_id');
		$user = Sentinel::findById(1);
		if($user ->hasAccess('admin')){
			
			$users = User::all()->count();
			$assignments = Assignment::all()->count();
			$vmachines = VMachine::all()->count();
			
			$view->with('courses',$courses)
				 ->with('users', $users)
				 ->with('assignments', $assignments)
				 ->with('vmachines', $vmachines);
		} else {
			$assignments = Assignment::leftJoin('enrollment', function($join) {
											$join->on('assignment.enrollment_id', '=', 'enrollment.id');
										})
										->leftJoin('course', function($join) {
											$join->on('assignment.course_id', '=', 'course.id');
										})
										->where('enrollment.user_id', '=', 1)
										->count();

			$view->with('courses',$courses)
				 ->with('assignments', $assignments);
		}

		return $view;
	}
	
	public function showProfile($userId)
	{
		try
		{
		    $user = Sentinel::findUserById($userId);

		    $profile = Profile::where('user_id', $userId)->first();
		    $enrollments = Enrollment::select('id')->where('user_id',$userId)->get()->toArray();
		    $courses = Course::profileCourses($userId);
		    $assignments = Assignment::profileAssignments($userId);
		    $vmachines = VMachine::profileVMachines($userId);
		    $avatar = Files::
		    			where('user_id', $userId)
		    			->where('type', 'avatar')
		    			->first();
		    
		    $view = view('dashboard/profile');
		    $view->with('user',$user)
		    	 ->with('profile',$profile)
		    	 ->with('assignments', $assignments)
		    	 ->with('courses', $courses)
		    	 ->with('vmachines', $vmachines)
				 ->with('avatar', $avatar);
		    
		    return $view;
		}
		catch (Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
		    echo 'User was not found.';
		}		
	}

	public function showUsers()
	{
		$users = Sentinel::getUserRepository()->get();
		
		$view = view('dashboard/users');
		$view->with('users', $users);

		return $view;
	}
	
	public function editUser($userId)
	{
		try
		{
		    $user 	= Sentinel::findUserById($userId);
		    $profile 	= Profile::where('user_id',$userId)->first();
		    $groups 	= array(100, 200, 300);
		    $group_name = array("G1", "G2", "G3");
		    /*$groups 	=  Sentinel::findAllGroups();
		    $group_name = array();

			foreach($user->getGroups() as $group)
			{
			     $group_name = $group->name;
			}*/

		    $avatar = Files::
		    			where('user_id', $userId)
		    			->where('type', 'avatar')
		    			->first();
		    
		    $view = view('dashboard/edituser');
		    $view->with('user', $user)
		    	 ->with('profile', $profile)
		    	 ->with('groups', $groups)
		    	 ->with('group_name', $group_name)
		    	 ->with('avatar', $avatar);
		    
		    return $view;
		}
		catch (Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
		    echo 'User was not found.';
		}
	}
	
	public function newUser()
	{
	
		//$groups = Sentinel::findAllGroups();
		$groups	= array(100, 200, 300);
		$view = view('dashboard/newuser');
		$view->with('groups', $groups);
		
		return $view;
	}
	
	public function storeUser(Request $request)
	{
		// Gather input
		$input = $request->input();

		// Set validation rules
		$rules = array(
					'firstname' => 'required|min:3', 
					'lastname' => 'required|min:3', 
					'email' => 'required|min:4|max:32|email', 
					'file' => 'mimes:png,gif,jpeg,jpg,bmp|max:500',
					'permission' => 'required',
				);

		$validator = Validator::make($input, $rules);
		
		if($validator -> fails()){
			return Redirect::to('/users/new')
					->withErrors($validator)
					->withInput($request->except(array('password','password_confirmation', 'file')));
		} else {
			try {

				if($input['permission']==1){
					$permission = array( 'admin' => 1, 'users' => 0);
				} else {
					$permission = array( 'admin' => 0, 'users' => 1);
				}

				// activate user
				$user = Sentinel::create(array(
									'first_name' => $input['firstname'], 
									'last_name' => $input['lastname'], 
									'email' => $input['email'], 
									'password' => $input['password'], 
									'activated' => $input['activated'],
									'permissions' => $permission,
								));
				
				$group = "G1"; //Sentinel::findGroupById($input['group']);
				
				//$user->addGroup($group);

				// upload file 
				if($request->hasFile('file')) {

					$upload = $input['file'];
					
					$fname = $upload->getClientOriginalName();
                    $size  = $upload->getSize();

                    $destinationPath = public_path() . '/uploads/avatars';

                    $filename = str_random(12);

                    $upload_success = $upload->move($destinationPath, $filename);

                    if ($upload_success) {
                        $file            = new Files;
                        $file->filename  = $filename;
                        $file->real_name = $fname;
                        $file->size      = $size;
                        $file->user_id   = $user->id;
                        $file->type 	 = "avatar";
                        $file->path 	 = public_path().'/uploads/avatars/';
                        $file->save();
                    }
				}

				// add optional information
				$profile = new Profile();
				$profile->user_id = $user->id;
				$profile->address = $input['address'];
				$profile->organization = $input['organization'];
				$profile->save();

				// success
				Session::flash('success_msg', 'User was successfully created.');
				return Redirect::to('/users');
			} catch (Cartalyst\Sentinel\Users\LoginRequiredException $e) {
			    Session::flash('error_msg', 'Login field is required.');
			    return Redirect::to('/users/new')->withErrors($validator)->withInput(Input::except('password', 'file'));
			}
			catch (Cartalyst\Sentinel\Users\PasswordRequiredException $e) {
			    Session::flash('error_msg', 'Password field is required.');
			    return Redirect::to('/users/new')->withErrors($validator)->withInput(Input::except('password', 'file'));
			}
			catch (Cartalyst\Sentinel\Users\UserExistsException $e) {
			    Session::flash('error_msg', 'User with this login already exists.');
			    return Redirect::to('/users/new')->withErrors($validator)->withInput(Input::except('password', 'file'));
			}
			catch (Cartalyst\Sentinel\Groups\GroupNotFoundException $e) {
			    Session::flash('error_msg', 'Group was not found.');
			    return Redirect::to('/users/new')->withErrors($validator)->withInput(Input::except('password', 'file'));
			}
		}

	}
	
	public function updateUser($userId)
	{
		// Gather input
		$input = Input::all();

		// Set validation rules
		$rules = array(
					'firstname' => 'required|min:3', 
					'lastname' => 'required|min:3', 
					'email' => 'required|min:4|max:32|email', 
					'password' => 'min:6|max:32|confirmed', 
					'password_confirmation' => 'min:6|max:32', 
					'file' => 'mimes:png,gif,jpeg,jpg,bmp|max:500' 
				);
		
		$validator = Validator::make($input, $rules);
		
		if($validator -> fails()){
			return Redirect::to('/users/edit/'.$userId)
					->withErrors($validator)
					->withInput(Input::except(array('password', 'password_confirmation', 'file')));
		} else {
		
			try
			{

				if($input['permission']==1){
					$permission = array( 'admin' => 1, 'users' => 0);
				} else {
					$permission = array( 'admin' => 0, 'users' => 1);
				}

			    $user = Sentinel::findUserById($userId);
			    $profile = Profile::where('user_id',$userId)->first();
			
			    $user->email 		= $input['email'];
			    $user->first_name 	= $input['firstname'];
			    $user->last_name 	= $input['lastname'];
			    $user->activated 	= $input['activated'];
			    $user->permissions 	= $permission;

			    if($input['password']!="") {
				    $user->password = $input['password'];
			    }

				// upload file 
				if(Input::hasFile('file')) {

					$upload = $input['file'];

					$file = Files::where('user_id', $userId)->first();
					if($file != NULL) {
						File::delete($file->path.$file->filename);
						$file->delete();
					} 					

					$fname = $upload->getClientOriginalName();
                    $size  = $upload->getSize();

                    $destinationPath = public_path() . '/uploads/avatars';

                    $filename = str_random(12);

                    $upload_success = $upload->move($destinationPath, $filename);

                    if ($upload_success) {
                    	$file 			  = new Files;
                        $file->filename   = $filename;
                        $file->real_name  = $fname;
                        $file->size       = $size;
                        $file->user_id    = $user->id;
                        $file->type 	  = "avatar";
                        $file->path 	  = public_path().'/uploads/avatars/';
                        $file->save();
                    }
				}

				// add optional information
				if($profile == NULL) {
					$profile = new Profile();
				}
				$profile->user_id = $userId;
				$profile->address = $input['address'];
				$profile->organization = $input['organization'];
				$profile->save();
			
			    // Update the user
			    if ($user->save())
			    {
			        Session::flash('success_msg', 'User was successfully updated');
					return Redirect::to('/users/edit/'.$userId);
			    }
			    else
			    {
			        Session::flash('error_msg', 'User information was not updated');
					return Redirect::to('/users/edit/'.$userId);
			    }
			}
			catch (Cartalyst\Sentinel\Users\UserExistsException $e)
			{
			    echo 'User with this login already exists.';
			}
			catch (Cartalyst\Sentinel\Users\UserNotFoundException $e)
			{
			    echo 'User was not found.';
			}
		}
	}
	
	public function deleteUser($userId)
	{
		try
		{
		    // Find the user using the user id
		    $user = Sentinel::findUserById($userId);
		    
		    // Delete the user
		    $user->delete();

		    // Delete profile
		    $profile = Profile::where('user_id', $userId)->delete();
		    
		    // Delete files
		    $files = Files::where('user_id', $userId)->get();
		    
		    foreach ($files as $file) 
		    {
	    		File::delete($file->path.$file->filename);
	    		$file->delete();
		    }

		    // Delete courses
		    $courses = Course::where('user_id', $userId)->delete();

		    Session::flash('success_msg', 'User was successfully deleted');
			return Redirect::to('/users');
		    
		}
		catch (Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
			Session::flash('error_msg', 'User was not found');
		    return Redirect::to('/users');
		}	
	}

}
