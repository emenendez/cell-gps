<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminController extends Controller {

	/**
	 * Show static admin page.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return view('admin');
	}

}
