<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Assignment extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'assignment';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public $timestamps = false;

	public static function profileAssignments($userId)
	{
		return Assignment::select(array(
					 	 	 	'assignment.id',
					 	 	 	'assignment.date_created',
					 	 	 	'assignment.date_started',
					 	 	 	'assignment.date_finished',
					 	 	 	'assignment.status',
					 	 	 	'assignment.percent',
					 	 	 	'course.name',
								))
								->leftJoin('enrollment', function($join) {
									$join->on('assignment.enrollment_id', '=', 'enrollment.id');
								})
								->leftJoin('course', function($join) {
									$join->on('assignment.course_id', '=', 'course.id');
								})
								//->whereIn('enrollment.id',( is_array($enrollments) && count($enrollments) ) ? $enrollments : [0])
								->where('enrollment.user_id', '=', $userId)
								->get();
	}

	public static function viewAssignment($id)
	{
		return Assignment::select(array(
					 	 	 	'assignment.id',
					 	 	 	'assignment.course_id',
					 	 	 	'assignment.vmachine_id',
					 	 	 	'assignment.date_created',
					 	 	 	'assignment.date_started',
					 	 	 	'assignment.date_finished',
					 	 	 	'assignment.status',
					 	 	 	'assignment.percent',
					 	 	 	'users.first_name',
					 	 	 	'users.last_name',
								))
								->leftJoin('enrollment', function($join) {
									$join->on('assignment.enrollment_id', '=', 'enrollment.id');
								})
								->leftJoin('users', function($join) {
									$join->on('enrollment.user_id', '=', 'users.id');
								})
								->where('assignment.id', '=', $id)
								->first();
	}

	public static function showAssignments()
	{
		return Assignment::select(array(
			 					'assignment.id', 
			 					'assignment.enrollment_id',
			 					'assignment.vmachine_id',
			 					'assignment.date_created',
			 					'assignment.date_started',
			 					'assignment.teacher_id',
			 					'assignment.date_finished',
			 					'assignment.status',
			 					'assignment.percent',
			 					'assignment.time_percent',
			 					'course.name',
			 					'vmachine.machine_id',
			 					'vmachine.machine_name',
			 					'enrollment.user_id',
			 					'users.first_name',
			 					'users.last_name',
			 					))
								->leftJoin('course', function($join) {
									$join->on('assignment.course_id', '=', 'course.id');
								})
								->leftJoin('vmachine', function($join) {
									$join->on('assignment.vmachine_id', '=', 'vmachine.id');
								})
								->leftJoin('enrollment', function($join) {
									$join->on('assignment.enrollment_id', '=', 'enrollment.id');
								})
								->leftJoin('users', function($join) {
									$join->on('enrollment.user_id', '=', 'users.id');
								})
								->get();
	}

	public static function listAssignments()
	{
		return Assignment::select(array(
					 	 	 	'assignment.id',
					 	 	 	'assignment.date_created',
					 	 	 	'assignment.date_started',
					 	 	 	'assignment.date_finished',
					 	 	 	'assignment.status',
					 	 	 	'assignment.percent',
					 	 	 	'course.name',
								))
								->leftJoin('enrollment', function($join) {
									$join->on('assignment.enrollment_id', '=', 'enrollment.id');
								})
								->leftJoin('course', function($join) {
									$join->on('assignment.course_id', '=', 'course.id');
								})
								->where('enrollment.user_id', '=', Sentry::getUser()->id)
								->get();
	}
}
