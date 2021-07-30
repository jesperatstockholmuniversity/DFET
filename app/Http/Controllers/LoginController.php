<?php
namespace App\Http\Controllers;
use App\Models\Files as Files;
use App\Models\User as User;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel as Sentinel;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

/*use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;*/

class LoginController extends Controller {

	public function __construct()
	{
		//$this->beforeFilter('csrf', $array('on' => 'post'));
	}

	// show login form
	public function showLogin() {
		return view('layouts/login');
	}

	//Authenticate User
	protected function storeLogin(Request $request) {
		// Gather input
		$inputs = array('email' => $request->input('email'), 'password' => $request->input('password'));
		//$user = Sentinel::findByCredentials($inputs);

		// Set validation rules
		$rules = array('email' => 'required|min:4|max:32|email', 'password' => 'required|min:6');

		$validator = Validator::make($inputs, $rules);

		if($validator->fails()){
			return Redirect::to('/login')->withErrors($validator)->withInput($request->except('password'));
		} else {
			try {
				$credentials = array(
					'email' => $request->input('email'),
					'password' => $request->input('password')
				);

				$user = Sentinel::authenticate($inputs, false);

			} catch (Cartalyst\Sentinel\Users\LoginRequiredException $e) {
			    Session::flash('error_msg', 'Login field is required.');
			    return Redirect::to('/login');
			} catch (Cartalyst\Sentinel\Users\PasswordRequiredException $e) {
			    Session::flash('error_msg', 'Password field is required.');
			    return Redirect::to('/login')->withInput($request->except('password'));
			} catch (Cartalyst\Sentinel\Users\WrongPasswordException $e) {
				Session::flash('error_msg', 'Wrong password, try again.');
			    return Redirect::to('/login')->withInput($request->except('password'));
			} catch (Cartalyst\Sentinel\Users\UserNotFoundException $e) {
			    Session::flash('error_msg', 'User was not found.');
			    return Redirect::to('/login');
			} catch (Cartalyst\Sentinel\Users\UserNotActivatedException $e) {
			    Session::flash('error_msg', 'User is not activated.');
			    return Redirect::to('/login');
			}

			// The following is only required if the throttling is enabled
			catch (Cartalyst\Sentinel\Throttling\UserSuspendedException $e) {
			    Session::flash('error_msg', 'User is suspended.');
			    return Redirect::to('/login')->withInput($request->except('password'));
			}
			catch (Cartalyst\Sentinel\Throttling\UserBannedException $e) {
			    Session::flash('error_msg', 'User is banned.');
			    return Redirect::to('/login')->withInput($request->except('password'));
			}
		}

		Session::flash('success_msg', 'Logged in successfully.');
		//$suser = Sentinel::findByCredentials($credentials);
		$suser = Session::get('id');
		$avatar = Files::
			where('user_id', $suser)
		    			->where('type', 'avatar')
		    			->first();
		    			
		if(isset($avatar))
			$user['avatar'] = $avatar->filename;
		
		Session::put('user', $user);
		return Redirect::to('/');
	}

	public function getLogout(){
		Sentinel::logout();
		return Redirect::to('/login');
	}

	// oAuth
	public function oAuthSocial($social_provider, $action = "") {
		if($action == "auth"){
			// process authentication
			try {
				Session::set('provider', $social_provider);
				Hybrid_Endpoint::process();
			} catch (Exception $e) {
				return Redirect::to('oauth');
			}
			return;
		}

		try {
			// create a HybridAuth object
			$socialAuth = new Hybrid_Auth(app_path() . '/config/hybridauth.php');
			// authenticate with Google
			$provider = $socialAuth->authenticate($social_provider);

			// fetch user profile
			$userProfile = $provider->getUserProfile();

		} catch(Exception $e) {
			// exception codes can be found on HybBridAuth's web site
			Session::flash('error_msg', $e -> getMessage());
            return Redirect::to('/signup');
		}

		//echo "Connected with: <b>{$provider->id}</b><br />";
		//echo "As: <b>{$userProfile->displayName}</b><br />";
		//echo "<pre>" . print_r( $userProfile, true ) . "</pre><br />";

		$this->createOAuthProfile($userProfile);
		return Redirect::to('/');
	}

	public function createOAuthProfile($userProfile) {

		if(isset($userProfile->firstName)) {
			$firstname = strlen($userProfile->firstName) > 0 ? $userProfile->firstName : "";
		}
		if(isset($userProfile->lastName)) {
			$lastname = strlen($userProfile->lastName) > 0 ? $userProfile->lastName : "";
		}
		if(isset($userProfile->email)) {
			$email = strlen($userProfile->email) > 0 ? $userProfile->email : "";
		}

		$password = str_random(20);

		if(User::where('email', $email)->count() <= 0)
		{
			$user = Sentinel::register(array('first_name' => $firstname, 
										   'last_name' => $lastname, 
										   'email' => $email, 
										   'password' => $password,
										   'permissions' => array(
										            'admin' => 0,
										            'users' => 1,
										        ),
										   ), true);

			// try {
			// 	$user_group = Sentry::findGroupById(1);
			// } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
			// 	$group = Sentry::createGroup(array(
			// 		'name' => 'Users', 
			// 		'permissions' => array(
			// 			'admin' => 1,
			// 			),
			// 		));
			// 	$user->addGroup($group);
			// }

			try
			{
				$user_group = Sentinel::findGroupById(1);
				if(!$user_group) {
					// Create the group
				    $group = Sentinel::createGroup(array(
				        'name'        => 'Users',
				        'permissions' => array(
				            'admin' => 0,
				            'users' => 0,
				        ),
				    ));
				    $user_group = Sentinel::findGroupById(1);
				}
			    $user->addGroup($user_group);

			} catch (Cartalyst\Sentinel\Groups\NameRequiredException $e) {
			    Session::flash('error_msg', 'Name field is required');
			    return Redirect::to('/signup');
			} catch (Cartalyst\Sentinel\Groups\GroupExistsException $e) {
			    Session::flash('error_msg', 'Group already exists');
			    return Redirect::to('/signup');
			} catch (Cartalyst\Sentinel\Groups\GroupNotFoundException $e) {
			    Session::flash('error_msg', 'Group was not found.');
			    return Redirect::to('/signup');
			}

		} 
		// User login
		try {
			$user = Sentinel::findUserByLogin($email);

			//$throttle = Sentinel::getThrottleProvider() -> findByUserId($user -> id);
			//$throttle -> check();

			// Authenticate user
			$credentials = array('email' => $email, 'password' => $request->input('password'));

			Sentinel::login($user, false);

			Session::flash('success_msg', 'Logged in successfully.');
			$avatar = Files::
			    			where('user_id', $user->id)
			    			->where('type', 'avatar')
			    			->first();
			    			
			if(isset($avatar))
				$user['avatar'] = $avatar->filename;
			
			Session::put('user', $user);
			return Redirect::to('/');
			
			//At this point we may get many exceptions lets handle all user management and throttle exceptions
		}  catch (Cartalyst\Sentinel\Users\LoginRequiredException $e) {
	        Session::flash('error_msg', 'Login field is required.');
	        return Redirect::to('/login');
	    } catch (Cartalyst\Sentinel\Users\PasswordRequiredException $e) {
	        Session::flash('error_msg', 'Password field is required.');
	        return Redirect::to('/login');
	    } catch (Cartalyst\Sentinel\Users\WrongPasswordException $e) {
	        Session::flash('error_msg', 'Wrong password, try again.');
	        return Redirect::to('/login');
	    } catch (Cartalyst\Sentinel\Users\UserNotFoundException $e) {
	        Session::flash('error_msg', 'User was not found.');
	        return Redirect::to('/login');
	    } catch (Cartalyst\Sentinel\Users\UserNotActivatedException $e) {
	        Session::flash('error_msg', 'User is not activated.');
	        return Redirect::to('/login');
	    } catch (Cartalyst\Sentinel\Throttling\UserSuspendedException $e) {
	        Session::flash('error_msg', 'User is suspended ');
	        return Redirect::to('/login');
	    } catch (Cartalyst\Sentinel\Throttling\UserBannedException $e) {
	        Session::flash('error_msg', 'User is banned.');
	        return Redirect::to('/login');
	    }
	}

	//Show signup Form
	public function showSignup() {
		return view('layouts/signup');
	}

	//Signup User
	public function storeSignup() {
		// Gather input
		$input = array('firstname' => $reuqest->input('firstname'), 
					   'lastname' => Input::get('lastname'), 
					   'email' => Input::get('email'), 
					   'password' => Input::get('password'), 
					   'password_confirmation' => Input::get('password_confirmation')
				);

		// Set validation rules
		$rules = array('firstname' => 'required|min:3', 
					   'lastname' => 'required|min:3', 
					   'email' => 'required|min:4|max:32|email', 
					   'password' => 'required|min:6|confirmed', 
					   'password_confirmation' => 'required' 
				);

		$validator = Validator::make($input, $rules);

		if($validator -> fails()){
			return Redirect::to('/signup')
							->withErrors($validator)
							->withInput(Input::except(array('password','password_confirmation')));
		} else {
			try {
				// activate user
				$user = Sentinel::register(array('first_name' => $input['firstname'], 
											   'last_name' => $input['lastname'], 
											   'email' => $input['email'], 'password' => $input['password'], 
											   '', 
											   'permissions' => array(
										            'admin' => 0,
										            'users' => 1,
										        ),
										));

				$data['activation_code'] = $user->getActivationCode();
				$data['email'] = $input['email'];
				$data['user_id'] = $user->getId();

				Mail::send('emails.signup_confirm', $data, function($m) use ($data) {
					$m -> to($data['email']) -> subject('Thanks for Registration - Support Team');
				});

				// try {
				// 	$user_group = Sentry::findGroupById(1);
				// } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
				// 	$group = Sentry::createGroup(array('name' => 'Users', 
				// 		'permissions' => array(
				// 			'admin' => 1,
				// 			),
				// 	));
				// 	$user->addGroup($group);
				// }

				try
				{
					$user_group = Sentinel::findGroupById(1);
					if(!$user_group) {
						// Create the group
					    $group = Sentinel::createGroup(array(
					        'name'        => 'Users',
					        'permissions' => array(
					            'admin' => 0,
					            'users' => 0,
					        ),
					    ));
					    $user_group = Sentinel::findGroupById(1);
					}
				    $user->addGroup($user_group);

				} catch (Cartalyst\Sentinel\Groups\NameRequiredException $e) {
				    Session::flash('error_msg', 'Name field is required');
				    return Redirect::to('/signup')->withErrors($validator)->withInput(Input::except(array('password','password_confirmation')));
				} catch (Cartalyst\Sentinel\Groups\GroupExistsException $e) {
				    Session::flash('error_msg', 'Group already exists');
				    return Redirect::to('/signup')->withErrors($validator)->withInput(Input::except(array('password','password_confirmation')));
				} catch (Cartalyst\Sentinel\Groups\GroupNotFoundException $e) {
				    Session::flash('error_msg', 'Group was not found.');
				    return Redirect::to('/signup')->withErrors($validator)->withInput(Input::except(array('password','password_confirmation')));
				}

				// success
				Session::flash('success_msg', 'Thanks for signup. Please activate your account by clicking activation link in your email');
				return Redirect::to('/signup');
			} catch (Cartalyst\Sentinel\Users\LoginRequiredException $e) {
				Session::flash('error_msg', 'Email Required.');
				return Redirect::to('/signup')->withErrors($validator)->withInput(Input::except(array('password','password_confirmation')));
			} catch (Cartalyst\Sentinel\Users\UserExistsException $e) {
				Session::flash('error_msg', 'User already exists.');
				return Redirect::to('/signup')->withErrors($validator)->withInput(Input::except(array('password','password_confirmation')));
			}
		}
	}

	public function signupActivate($user_id, $activation_code) {
		try {
			$user = Sentinel::findUserById($user_id);

			if($user->attemptActivation($activation_code)) {
				Session::flash('success_msg', 'User activation successful. Please login below.');
				return Redirect::to('/login');
			} else {
				Session::flash('error_msg', 'Unable to activate user. Try again later or contact support team.');
				return Redirect::to('/signup');
			} 
		} catch (Cartalyst\Sentinel\Users\UserNotFoundException $e) {
			Session::flash('error_msg', 'User was not found.');
			return Redirect::to('/signup');
		} catch (Cartalyst\Sentinel\Users\UserAlreadyActivatedException $e) {
			Session::flash('error_msg', 'User is already activated.');
			return Redirect::to('/login');
		}
	}

	//Show forgotpassword Form
	public function showForgotpassword() {
		return view('layouts/forgotpassword');
	}
 
	//Send email for forgot password
	public function storeForgotpassword() {
			
		$email = Input::get('email');
		$inputs = array('email' => $email);
		// Set validation rules
		$rules = array('email' => 'required|min:4|max:32|email');

		$validator = Validator::make($inputs, $rules);

		if($validator->fails()){
			return Redirect::to('/forgotpassword')->withErrors($validator);
		} else {

			try {
				$user = Sentinel::findUserByLogin($email);
				$reset_code = $user->getResetPasswordCode();

				Mail::send('emails.resetpassword', array('email' => $email, 'reset_code' => $reset_code), function($m) use ($email,$reset_code) {
					$m -> to($email) -> subject('Follow the link to reset your password');
				});

				Session::flash('success_msg', 'We have sent you a link to your email account please follow that to reset your password.');
				return Redirect::to('/forgotpassword');
			} catch (Cartalyst\Sentinel\Users\UserNotFoundException $e) {
				Session::flash('error_msg', 'User not found');
				return Redirect::to('/forgotpassword');
			}
		} 
	}
	 
	//Show newpassword Form
	public function showNewPassword() {
		return view('layouts/newpassword');
	}
	 
	//Store new password
	public function storeNewPassword() {

		$resetcode = trim(Input::get('resetcode'));

		// Gather input
		$inputs = array('password' => Input::get('password'), 'password_confirmation' => Input::get('password_confirmation'));

		// Set validation rules
		$rules = array('password' => 'required|min:6|max:32|confirmed', 'password_confirmation' => 'required|min:6|max:32');

		$validator = Validator::make($inputs, $rules);

		if($validator->fails()){
			return Redirect::to('/newpassword?email=' . Input::get('email') . '&resetcode=' . $resetcode)->withErrors($validator)->withInput();
		} else {
			try {
				$user = Sentinel::findUserByLogin(Input::get('email'));

				// Validate reset code
				if($user->checkResetPasswordCode($resetcode)) {	
					// Attempt to reset password
					if($user->attemptResetPassword($resetcode, Input::get('password'))) {
						Session::flash('success_msg', 'Password changed successfully');
						return Redirect::to('/login');
					} else {
						Session::flash('error_msg', 'Unable to reset password. Please try again.');
						return Redirect::to('/forgotpassword');
					}
				} else {
					Session::flash('error_msg', 'Unable to reset password. Invalid reset code. Please try again.');
					return Redirect::to('/forgotpassword');
				}
			} catch (Cartalyst\Sentinel\Users\UserNotFoundException $e) {
				Session::flash('error_msg', 'User not found.');
				return Redirect::to('forgotpassword');
			}
		}
	}

}
