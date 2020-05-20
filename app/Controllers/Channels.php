<?php namespace App\Controllers;

use App\Models\ChannelsModel;
use App\Models\CommentsModel;
use App\Models\LikesModel;

class Channels extends BaseController 
{	
	//FFMPEG Credentials Global.
	private $create = [];

	//Path to uploaded videos to convert.
	private $tmp_path = ROOTPATH . 'public/vids/tmp/';

	//Path to converted videos.
	private $v_ouput_path = ROOTPATH . 'public/vids/outputs/';

	//Path to video thumbnails.
	private $thumb_path = ROOTPATH . 'public/vids/thumbs/';

	//Path to progress logs.
	private $progress_path = ROOTPATH . 'public/vids/progress_log/';

	//Channels Model Property Global.
	private $channels;

	//Comments Model Property Global;
	private $comments;

	//Likes Model Property Global.
	private $likes;

	public function __construct()
	{
		parent::__construct();

		//FFMPEG Credentials.
		$this->create = [
			'ffmpeg.binaries'  => env('ffmpeg.binaries'),
			'ffprobe.binaries' => env('ffprobe.binaries'),
			'timeout'          => 3600,
			'ffmpeg.threads'   => 12
		];

		//Load ChannelsModel.
		$this->channels = new ChannelsModel();

		//Load CommentsModel.
		$this->comments = new CommentsModel();

		//Load LikesModel.
		$this->likes = new LikesModel();
	}

	public function watch()
	{
		if ($this->channels->slug_exists($this->Assets->get_last_uri()))
		{
			$this->channels->view($this->Assets->get_last_uri());

			$title = $this->channels->get_video($this->Assets->get_last_uri())['title'];
			$video_data = $this->channels->get_video($this->Assets->get_last_uri());
			$lastest_videos = $this->channels->get_latest_videos($this->Assets->get_last_uri());

			$data = [
				'title' => $title . ' - CI4',
				'data' => $video_data,
				'comments' => $this->comments,
				'latest_videos' => $lastest_videos,
			];

			return view('channels/watch', $data);
		} 
		else 
		{
			die('slug not exists');
		} 
	}

	public function comments()
	{
		if ($this->request->isAjax())
		{
			$video_id = $this->request->getPostGet('video_id');
			$slug = $this->request->getPostGet('slug');
			$page = $this->request->getPostGet("page");
			$total_comments = $this->comments->_countAll($video_id, $slug);
			$comments = $this->comments->get($video_id, $slug, $page);

			$data = [
				'total_comments' => $total_comments,
				'comments' => $comments,
				'comments_model' => $this->comments,
			];

			return view('channels/comments', $data);
		}
	}

	public function postcomment()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$video_id = $this->request->getPostGet('video_id');
			$user_id = $this->request->getPostGet('user_id');
			$slug = $this->request->getPostGet('slug');
			$comment = $this->Assets->filter_tags($this->request->getPostGet('comment'));
			$data = [
				'user_id' => $user_id,
				'video_id' => $video_id,
				'video_slug' => $slug,
				'comment' => $comment,
			];

			if ($this->comments->_insert($data))
			{
				echo 'ok';
			}
		}
	}

	public function deletecomment()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			if ($this->comments->is_comment_author($this->Assets->getUserId($this->Assets->getSession('username')), $this->request->getPostGet('comment_id')))
			{
				$video_id = $this->request->getPostGet('video_id');
				$slug = $this->request->getPostGet('slug');
				$comment_id = $this->request->getPostGet('comment_id');

				if ($this->comments->_delete($video_id, $slug, $comment_id)) 
				{
					echo 'ok';
				}
			}
		}
	}

	public function like()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$video_id = $this->request->getPostGet('video_id');
			$slug = $this->request->getPostGet('slug');
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

			if ($this->likes->alreadyliked($video_id, $slug, $user_id))
			{
				$count = $this->channels->update_like($slug);
				$this->likes->add_like($video_id, $slug, $user_id);

				echo $count;
			}
		}
	}

	public function mychannel()
	{
		if ($this->Assets->hasSession())
		{
			$data = [
				'title' => 'My Channel - CI4',
			];
	
			return view('channels/mychannel', $data);
		}
		else
		{
			return redirect()->to('/login?redirect=mychannel');
		}
	}

	public function upload()
	{
		if ($this->Assets->hasSession())
		{
			$data = [
				'title' => 'Upload - CI4'
			];

			return view('channels/upload', $data);
		}
		else
		{
			return redirect()->to('/login?redirect=upload');
		}
	}

	public function doupload() 
	{
		if ($this->request->isAjax() && $this->Assets->hasSession()) 
		{
			$file_name = $this->Assets->randomstr(30);

			$orig_filename = $_FILES['video']['name'];
			$tmp = $_FILES['video']['tmp_name'];
			$ext = $this->Assets->get_file_ext($orig_filename);
			$tmp_filename = $file_name . '.' . $ext;
			$new_filename = $file_name . '.mp4';
			$slug = $this->request->getPostGet('slug');

			if ($this->Assets->is_valid_video($ext) && move_uploaded_file($tmp, './vids/tmp/' . $tmp_filename)) 
			{

				if (! $this->channels->is_record_exists($slug)) {
					$data = [
						'user_id' => $this->Assets->getUserId($this->Assets->getSession('username')),
						'slug' => $slug,
						'title' => 'Untitled Video',
						'orig_filename' => $orig_filename,
						'filename' => $new_filename,
						'converted' => 0,
						'likes' => 0,
						'views' => 0,
					];

					$this->channels->create_record($data);
				}
				else
				{
					$data = [
						'user_id' => $this->Assets->getUserId($this->Assets->getSession('username')),
						'slug' => $slug,
						'orig_filename' => $orig_filename,
						'filename' => $new_filename,
						'converted' => 0,
						'likes' => 0,
						'views' => 0,
					];

					$this->channels->update_record($data);
				}

				$output = [
					'filename' => $tmp_filename,
					'slug' => $slug
				];

				$this->response->setHeader('Content-Type', 'application/json');
				echo json_encode($output);
			}
		}
	}

	public function doconvert() 
	{
		if ($this->request->isAjax() && $this->Assets->hasSession()) 
		{
			$video_to_convert = $this->request->getPostGet('filename');
			$slug = $this->request->getPostGet('slug');
			$new_filename = $this->channels->get_new_filename($slug);
			$progress_file = $this->progress_path . 'progress_' . $slug . '.txt';
			$watermark = './img/watermark.png';

			$ffmpeg = \FFMpeg\FFMpeg::create($this->create);

			$video = $ffmpeg->open($this->tmp_path . $video_to_convert);

			$video->filters()
				->watermark($watermark, [
					'position' => 'relative',
					'bottom' => 20,
					'right' => 20,
				]);

			$video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(10))
				 ->save($this->thumb_path . $slug . '.jpg');

			$format = new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264');
			$format->on('progress', function ($video, $format, $percentage) use ($progress_file) 
			{
				$progress = fopen($progress_file, 'w');	
				fwrite($progress, $percentage);
				fclose($progress);
			});
			$format->setKiloBitrate(389);

			$ffprobe = \FFMpeg\FFProbe::create();
			$video_duration = $ffprobe->format($this->tmp_path . $video_to_convert)
					->get('duration');
			
			if ($video->save($format, $this->v_ouput_path . $new_filename))
			{
				//Update data.
				$data = [
					'converted' => 1,
					'length' => $this->Assets->video_duration($video_duration),
				];

				//Update converted record.
				$this->channels->update_record_after_converting($slug, $data);

				//Delete uploaded file from /vids/tmp.
				if (file_exists($this->tmp_path . $video_to_convert))
				{
					unlink($this->tmp_path . $video_to_convert);
				}

				//Delete progress log file.
				if (file_exists($progress_file))
				{
					unlink($progress_file);
				}

				echo 'ok';
			}
		}
	}

	public function savevideodetails()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession()) 
		{	
			$slug = $this->request->getPostGet('slug');
			$title = $this->request->getPostGet('title');
			$description = $this->request->getPostGet('description');
			$tags = $this->request->getPostGet('tags');
			
			if (! $this->channels->is_record_exists($slug))
			{
				$data = [
					'user_id' => $this->Assets->getUserId($this->Assets->getSession('username')),
					'slug' => $slug,
					'title' => (!$title) ? 'Untitled Video' : $title,
					'description' => filter_tags($description),
					'tags' => $tags,
					'converted' => 0,
					'likes' => 0,
					'views' => 0,
				];

				$this->channels->create_record($data);
			}
			else
			{
				$data = [
					'user_id' => $this->Assets->getUserId($this->Assets->getSession('username')),
					'slug' => $slug,
					'title' => (!$title) ? 'Untitled Video' : $title,
					'description' => filter_tags($description),
					'tags' => $tags,
					'converted' => 0,
					'likes' => 0,
					'views' => 0,
				];

				$this->channels->update_details_record($data);
			}

			echo 'ok';
		}
	}
}
