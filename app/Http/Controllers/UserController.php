<?php
namespace App\Http\Controllers;
use App\Models\User as User;

class UserController extends BaseController {

	public function __construct()
	{
		//$this->beforeFilter('csrf', $array('on' => 'post'));
	}

	public function dashboard()
	{
	 	return view('dashboard/index');
	}

	public function showCalender()
	{
		return view('dashboard/calendar');
	}
	
	public function editProfile($userId)
	{
		try
		{
		    $user = Sentinel::findUserById($userId);
		    $profile 	= Profile::where('user_id',$userId)->first();

		    $avatar = Files::
		    			where('user_id', $userId)
		    			->where('type', 'avatar')
		    			->first();
		    
		    $view = view('dashboard/settings');
		    $view->with('user', $user)
		    	 ->with('profile', $profile)
		    	 ->with('avatar', $avatar);
		    
		    return $view;
		}
		catch (Cartalyst\Sentinel\Users\UserNotFoundException $e)
		{
		    echo 'User was not found.';
		}
	}
	
	public function updateProfile($userId)
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
			return Redirect::to('/users/settings/'.$userId)
					->withErrors($validator)
					->withInput(Input::except(array('password', 'password_confirmation', 'file')));
		} else {
		
			try
			{
			    $user = Sentinel::findUserById($userId);
			    $profile = Profile::where('user_id',$userId)->first();
			
			    $user->email = Input::get('email');
			    $user->first_name = Input::get('firstname');
			    $user->last_name = Input::get('lastname');
			    //$user->activated = Input::get('activated');

			    if(Input::get('password')!="") {
				    $user->password = Input::get('password');
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
			        Session::flash('success_msg', 'Your profile was successfully updated');
					return Redirect::to('/users/settings/'.$userId);
			    }
			    else
			    {
			        Session::flash('error_msg', 'Your profile was not updated');
					return Redirect::to('/users/settings/'.$userId);
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

}
