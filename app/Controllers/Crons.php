<?php namespace App\Controllers;

use Carbon\Carbon;
use App\Models\ChannelsModel;

class Crons extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        //Current date and time.
        $now = Carbon::now();

        //Path to uploaded videos to convert.
        $tmp_path = ROOTPATH . 'public/vids/tmp/';

        //Path to video thumbnails.
        $thumb_path = ROOTPATH . 'public/vids/thumbs/';
        
        //Path to progress logs.
        $progress_path = ROOTPATH . 'public/vids/progress_log/';
        
        //Path to converted videos.
	    $v_output_path = ROOTPATH . 'public/vids/outputs/';

        $channels = new ChannelsModel();

        //Check expired records for removal.
        foreach ($channels->fetch_failed_videos() as $video)
        {        
            //Remove item if expired.
            if ($now >= Carbon::create($video['created_at'])->add(12, 'hours'))
            {
                $file_name = rtrim($video['filename'], '.mp4');
                $orig_filename = explode('.', $video['orig_filename']);
                $orig_filename_ext = end($orig_filename);
                $tmp_file = $file_name . '.' . $orig_filename_ext;

                //Remove video file from tmp dir.
                if (file_exists($tmp_path . $tmp_file))
                {
                    unlink($tmp_path . $tmp_file);
                }

                //Remove progess log file.
                if (file_exists($progress_path. 'progress_' . $video['slug'] . '.txt'))
                {
                    unlink($progress_path. 'progress_' . $video['slug'] . '.txt');
                }

                //Remove thumbnail.
                if (file_exists($thumb_path . $video['slug'] . '.jpg'))
                {
                    unlink($thumb_path . $video['slug'] . '.jpg');
                }

                //Remove video file from output dir.
                if (file_exists($v_output_path . $video['filename']))
                {
                    unlink($v_output_path . $video['filename']);
                }

                //Delete record from database.
                $channels->delete_video($video['id']);
            }
        }
    }
}