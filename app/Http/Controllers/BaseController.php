<?php
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = view($this->layout);
		}

		$enrollreviews = Enrollment::where('status','inreview')->count();
		View::share('enrollreviews', $enrollreviews);
	}

}
