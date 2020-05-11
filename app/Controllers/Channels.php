<?php namespace App\Controllers;

class Channels extends BaseController {

	public function mychannel()
	{
		$data = [
			'title' => 'My Channel - CI4'
		];

		return view('channels/mychannel', $data);
	}
}
