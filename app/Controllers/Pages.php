<?php namespace App\Controllers;

class Pages extends BaseController {
	public function index()
	{
		$ffmpeg = \FFMpeg\FFMpeg::create(array(
		    'ffmpeg.binaries'  => 'C:\ffmpeg-20200420-cacdac8-win64-static\bin\ffmpeg.exe',
		    'ffprobe.binaries' => 'C:\ffmpeg-20200420-cacdac8-win64-static\bin\ffprobe.exe',
		    'timeout'          => 3600, // The timeout for the underlying process
		    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
		));

		$video = $ffmpeg->open(ROOTPATH . 'public/vids/inputs/test.mp4');

		if ($video->save(new \FFMpeg\Format\Video\WMV(), ROOTPATH . 'public/vids/outputs/export-wmv.wmv')) {
		    echo 'Done!';
		}

		$data = [
			'title' => 'Sample Title',
		];

		return view('pages/home', $data);
	}
}
