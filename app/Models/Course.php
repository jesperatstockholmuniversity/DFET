<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth;

class Course extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'course';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public static $rules = array( 
		'name' => 'required| unique:course',
		'description' => 'required',
		'preview' => 'mimes:png,gif,jpeg,jpg,bmp|max:5000'
		);

	public static $update_rules = array( 
		'name' => 'required',
		'description' => 'required',
		'preview' => 'mimes:png,gif,jpeg,jpg,bmp|max:5000'
		);

	public static function listCourses()
	{
		//$authData = Auth::user();
		//dd($authData);
		//$userId = $authData->id;
		return Course::select(array(
						        'course.id',
						        'course.name',
						        'course.description',
						        'course.updated_at',
						        'course.created_at',
						        'users.id AS user_id',
						        'users.first_name',
						        'users.last_name',
						        'files.id AS file_id',
						        'files.type',
						        'files.filename',
						        'enrollment.status'
						    ))
							->leftJoin('users', function($join) {
								$join->on('course.user_id', '=', 'users.id');
							})
							->orderBy('course.created_at', 'desc')
							->leftJoin('files', function($join) {
								$join->on('files.course_id', '=', 'course.id')
								->where('type', '=', 'course');
							})
							->leftJoin('enrollment', function($join) {
								$join->on('enrollment.course_id', '=', 'course.id')
								->where('enrollment.user_id', '=', $user_id);
							})
						    ->paginate(3);
	}

	public static function profileCourses($userId)
	{
		return Course::select(array(
						        'course.id',
						        'course.name',
						        'course.description',
						        'course.updated_at',
						        'course.created_at',
						        'enrollment.status'
						    ))
							->leftJoin('enrollment', function($join) {
								$join->on('enrollment.course_id', '=', 'course.id');
							})
							->orderBy('course.created_at', 'desc')
							->where('enrollment.user_id', '=', $userId)
						    ->get();
	}
}
