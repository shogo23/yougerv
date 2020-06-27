<?php namespace App\Controllers;

use App\Models\ChannelsModel;
use App\Models\UsersModel;
use App\Models\CommentsModel;
use App\Models\LikesModel;
use App\Models\WallsModel;
use App\Models\SubscriptionsModel;
use App\Models\NotificationsModel;

class Channels extends BaseController
{
	//FFMPEG Credentials Global.
	private $create = [];

	//Path to uploaded videos to convert.
	private $tmp_path = ROOTPATH . 'public/vids/tmp/';

	//Path to converted videos.
	private $v_output_path = ROOTPATH . 'public/vids/outputs/';

	//Path to video thumbnails.
	private $thumb_path = ROOTPATH . 'public/vids/thumbs/';

	//Path to progress logs.
	private $progress_path = ROOTPATH . 'public/vids/progress_log/';

	//Channels Model Property Global.
	private $channels;

	//Users Model Property Global.
	private $users;

	//Comments Model Property Global;
	private $comments;

	//Likes Model Property Global.
	private $likes;

	//Walls Model Property Global.
	private $walls;

	//Subscriptions Model Property Global.
	private $subscriptions;

	//Notification Model Property Global.
	private $notifications;

	//Securing Video Key. (video.mp4?key=anykey)
	private $secure_video_key;

	public function __construct()
	{
		parent::__construct();

		//FFMPEG Credentials.
		$this->create = [
			'ffmpeg.binaries'  => env('ffmpeg.binaries'),
			'ffprobe.binaries' => env('ffprobe.binaries'),
			'timeout'          => 3600,
			'ffmpeg.threads'   => 12,
		];

		//Load ChannelsModel.
		$this->channels = new ChannelsModel();

		//Load UsersModel.
		$this->users = new UsersModel();

		//Load CommentsModel.
		$this->comments = new CommentsModel();

		//Load LikesModel.
		$this->likes = new LikesModel();

		//Load WallsModel.
		$this->walls = new WallsModel();

		//Load SubscriptionsModel.
		$this->subscriptions = new SubscriptionsModel();

		//Load Notifications Model.
		$this->notifications = new NotificationsModel();

		//Set Secure Video Key.
		$this->secure_video_key = $this->Assets->randomstr(10);
	}

	public function watch()
	{
		if ($this->channels->slug_exists($this->Assets->get_last_uri()))
		{
			$this->channels->view($this->Assets->get_last_uri());

			$title          = $this->channels->get_video_info($this->Assets->get_last_uri())['title'];
			$user_id        = $this->channels->get_video_info($this->Assets->get_last_uri())['user_id'];
			$video_data     = $this->channels->get_video_info($this->Assets->get_last_uri());
			$lastest_videos = $this->channels->get_latest_videos($this->Assets->get_last_uri());

			//Expire on 6 hours.
			setcookie('secure_video', $this->secure_video_key, time() + 21600, '/');

			$data = [
				'title'            => $title . $this->web_title,
				'data'             => $video_data,
				'comments'         => $this->comments,
				'user_id'          => $user_id,
				'latest_videos'    => $lastest_videos,
				'secure_video_key' => $this->secure_video_key,
			];

			return view('channels/watch', $data);
		}
		else
		{
			$data = [
				'title' => 'Video Not Found' . $this->web_title,
			];

			return view('channels/videonotfound', $data);
		}
	}

	public function comments()
	{
		if ($this->request->isAjax())
		{
			$video_id       = $this->request->getPostGet('video_id');
			$slug           = $this->request->getPostGet('slug');
			$page           = $this->request->getPostGet('page');
			$total_comments = $this->comments->_countAll($video_id, $slug);
			$comments       = $this->comments->get($video_id, $slug, $page);

			$data = [
				'total_comments' => $total_comments,
				'comments'       => $comments,
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
			$user_id  = $this->request->getPostGet('user_id');
			$slug     = $this->request->getPostGet('slug');
			$comment  = $this->Assets->filter_tags($this->request->getPostGet('comment'));
			$data     = [
				'user_id'    => $user_id,
				'video_id'   => $video_id,
				'video_slug' => $slug,
				'comment'    => $comment,
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
				$video_id   = $this->request->getPostGet('video_id');
				$slug       = $this->request->getPostGet('slug');
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
			$slug     = $this->request->getPostGet('slug');
			$user_id  = $this->Assets->getUserId($this->Assets->getSession('username'));

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
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

			$data = [
				'title'        => 'My Channel' . $this->web_title,
				'user_details' => $this->users->user_details($user_id),
			];

			return view('channels/mychannel', $data);
		}
		else
		{
			return redirect()->to('/login?redirect=mychannel');
		}
	}

	public function mywall()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$data = [
				'user_id' => $this->request->getPostGet('user_id'),
			];

			return view('channels/mychannel/mywall', $data);
		}
	}

	public function createwallpost()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$data = [
				'wall_owner_id' => $this->request->getPostGet('user_id'),
				'poster_id'     => $this->request->getPostGet('user_id'),
				'post'          => $this->Assets->filter_tags($this->request->getPostGet('post')),
				'approved'      => 1,
			];

			if ($this->walls->insert_wallpost($data))
			{
				echo 'ok';
			}
		}
	}

	public function getwallposts()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id = $this->request->getPostGet('user_id');
			$data    = [
				'user_id'     => $user_id,
				'walls'       => $this->walls,
				'mywallposts' => $this->walls->get_posts($user_id),
			];

			return view('channels/mychannel/loadwallposts', $data);
		}
	}

	public function loadmorewallposts()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id = $this->request->getPostGet('user_id');
			$offset  = $this->request->getPostGet('offset');

			$data = [
				'user_id'     => $user_id,
				'mywallposts' => $this->walls->more_posts($user_id, $offset),
			];

			return view('channels/mychannel/loadmorewallposts', $data);
		}
	}

	public function approvewallpost()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id = $this->request->getPostGet('user_id');
			$post_id = $this->request->getPostGet('post_id');

			if ($this->walls->is_wall_owner($user_id, $post_id) && $this->walls->approve_post($post_id))
			{
				echo 'ok';
			}
		}
	}

	public function updatewallpost()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id = $this->request->getPostGet('user_id');
			$post_id = $this->request->getPostGet('post_id');
			$post    = $this->Assets->filter_tags($this->request->getPostGet('post'));

			if ($this->walls->is_post_owner($user_id, $post_id) && $this->walls->update_owner_post($user_id, $post_id, $post))
			{
				echo $post;
			}
		}
	}

	public function deletewallpost()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id = $this->request->getPostGet('user_id');
			$post_id = $this->request->getPostGet('post_id');

			if ($this->walls->is_post_belongs_to_your_wall($user_id, $post_id) && $this->walls->delete_post($post_id))
			{
				echo 'ok';
			}
		}
	}

	public function myvideos()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$data = [
				'user_id' => $this->Assets->getUserId($this->Assets->getSession('username')),
				'videos'  => $this->channels->mychannel_videos($this->request->getPostGet('user_id')),
			];

			return view('channels/mychannel/myvideos', $data);
		}
	}

	public function loadmorevideos()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id        = $this->request->getPostGet('user_id');
			$offset         = $this->request->getPostGet('offset');
			$data['videos'] = $this->channels->load_more_videos($user_id, $offset);

			return view('channels/mychannel/loadmorevideos', $data);
		}
	}

	public function editdetails()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$video_id         = $this->request->getPostGet('video_id');
			$data['video_id'] = $video_id;
			$data['videos']   = $this->channels->get_video_details($video_id);

			return view('channels/mychannel/editvideodetails', $data);
		}
	}

	public function savedetails()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$video_id = $this->request->getPostGet('video_id');

			$data = [
				'title'       => $this->request->getPostGet('title'),
				'description' => $this->Assets->filter_tags($this->request->getPostGet('description')),
				'tags'        => $this->request->getPostGet('tags'),
			];

			if ($this->channels->update_video_details($data, $video_id))
			{
				echo $this->Assets->reduce_title($this->request->getPostGet('title'));
			}
		}
	}

	public function deletevideo()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$video_id = $this->request->getPostGet('video_id');
			$video    = $this->channels->get_video_details($video_id);

			//Delete Thumb Picture
			if (file_exists($this->thumb_path . $video[0]['slug'] . '.jpg'))
			{
				unlink($this->thumb_path . $video[0]['slug'] . '.jpg');
			}

			//Delete Video file.
			if (file_exists($this->v_output_path . $video[0]['filename']))
			{
				unlink($this->v_output_path . $video[0]['filename']);
			}

			//Delete Database Record.
			if ($this->channels->delete_video($video_id))
			{
				echo 'ok';
			}
		}
	}

	public function mysubscribers()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

			$data = [
				'user_id'     => $user_id,
				'subscribers' => $this->subscriptions->get_subscribers($user_id),
			];

			return view('channels/mychannel/mysubscribers', $data);
		}
	}

	public function removemysubscriber()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id       = $this->Assets->getUserId($this->Assets->getSession('username'));
			$subscriber_id = $this->request->getPostGet('subscriber_id');

			if ($this->subscriptions->remove_subscriber($user_id, $subscriber_id))
			{
				echo 'ok';
			}
		}
	}

	public function mysubscription()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$subscriber_id = $this->Assets->getUserId($this->Assets->getSession('username'));
			$data          = [
				'subscriber_id' => $subscriber_id,
				'subscriptions' => $this->subscriptions->get_subscriptions($subscriber_id),
			];

			return view('channels/mychannel/mysubscriptions', $data);
		}
	}

	public function removemysubscription()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$subscriber_id = $this->Assets->getUserId($this->Assets->getSession('username'));
			$user_id       = $this->request->getPostGet('user_id');

			if ($this->subscriptions->remove_subscription($subscriber_id, $user_id))
			{
				echo 'ok';
			}
		}
	}

	public function upload()
	{
		if ($this->Assets->hasSession())
		{
			$data = [
				'title' => 'Upload - CI4',
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
			$tmp           = $_FILES['video']['tmp_name'];
			$ext           = $this->Assets->get_file_ext($orig_filename);
			$tmp_filename  = $file_name . '.' . $ext;
			$new_filename  = $file_name . '.mp4';
			$slug          = $this->request->getPostGet('slug');

			if ($this->Assets->is_valid_video($ext) && move_uploaded_file($tmp, './vids/tmp/' . $tmp_filename))
			{
				if (! $this->channels->is_record_exists($slug))
				{
					$data = [
						'user_id'       => $this->Assets->getUserId($this->Assets->getSession('username')),
						'slug'          => $slug,
						'title'         => 'Untitled Video',
						'orig_filename' => $orig_filename,
						'filename'      => $new_filename,
						'converted'     => 0,
						'likes'         => 0,
						'views'         => 0,
					];

					$this->channels->create_record($data);
				}
				else
				{
					$data = [
						'user_id'       => $this->Assets->getUserId($this->Assets->getSession('username')),
						'slug'          => $slug,
						'orig_filename' => $orig_filename,
						'filename'      => $new_filename,
						'converted'     => 0,
						'likes'         => 0,
						'views'         => 0,
					];

					$this->channels->update_record($data);
				}

				$output = [
					'filename' => $tmp_filename,
					'slug'     => $slug,
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
			$slug             = $this->request->getPostGet('slug');
			$new_filename     = $this->channels->get_new_filename($slug);
			$progress_file    = $this->progress_path . 'progress_' . $slug . '.txt';
			$watermark        = './img/watermark.png';

			$ffmpeg = \FFMpeg\FFMpeg::create($this->create);

			$video = $ffmpeg->open($this->tmp_path . $video_to_convert);

			$video->filters()
				->watermark($watermark, [
					'position' => 'relative',
					'bottom'   => 20,
					'right'    => 20,
				]);

			$video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(10))
				 ->save($this->thumb_path . $slug . '.jpg');

			$format = new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264');
			$format->on('progress', function ($video, $format, $percentage) use ($progress_file) {
								file_put_contents($progress_file, $percentage);
			});
			$format->setKiloBitrate(389);

			$ffprobe        = \FFMpeg\FFProbe::create();
			$video_duration = $ffprobe->format($this->tmp_path . $video_to_convert)
					->get('duration');

			if ($video->save($format, $this->v_output_path . $new_filename))
			{
				//Update data.
				$data = [
					'converted' => 1,
					'length'    => $this->Assets->video_duration($video_duration),
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
			$slug        = $this->request->getPostGet('slug');
			$title       = $this->request->getPostGet('title');
			$description = $this->request->getPostGet('description');
			$tags        = $this->request->getPostGet('tags');

			if (! $this->channels->is_record_exists($slug))
			{
				$data = [
					'user_id'     => $this->Assets->getUserId($this->Assets->getSession('username')),
					'slug'        => $slug,
					'title'       => (! $title) ? 'Untitled Video' : $title,
					'description' => $this->Assets->filter_tags($description),
					'tags'        => $tags,
					'converted'   => 0,
					'likes'       => 0,
					'views'       => 0,
				];

				$this->channels->create_record($data);
			}
			else
			{
				$data = [
					'user_id'     => $this->Assets->getUserId($this->Assets->getSession('username')),
					'slug'        => $slug,
					'title'       => (! $title) ? 'Untitled Video' : $title,
					'description' => $this->Assets->filter_tags($description),
					'tags'        => $tags,
					'converted'   => 0,
					'likes'       => 0,
					'views'       => 0,
				];

				$this->channels->update_details_record($data);
			}

			echo 'ok';
		}
	}

	public function videostream()
	{
		$filename = $this->Assets->get_last_uri();
		$key      = $this->request->getPostGet('key');

		if (file_exists($this->v_output_path . $filename) && $key && isset($_COOKIE['secure_video']) && $_COOKIE['secure_video'] === $key)
		{
			header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
			header('Cache-Control: public');
			header('Content-Type: video/mp4');
			header('Accept-Ranges: bytes');
			header('Content-Transfer-Encoding: Binary');
			header('Content-Length:' . filesize($this->v_output_path . $filename));
			header("Content-Disposition: attachment; filename=$filename");
			readfile($this->v_output_path . $filename);
		}
		else
		{
			die('Forbidden Access');
		}
	}

	public function userchannel()
	{
		$uri                    = explode('/', uri_string());
		$channel_owner_id       = $uri[1];
		$channel_owner_fullname = explode('_', $uri[2]);
		$firstname              = $channel_owner_fullname[0];
		$lastname               = $channel_owner_fullname[1];
		$session_user_id        = $this->Assets->getUserId($this->Assets->getSession('username'));

		/*
		*	If user is logged in and channel is owned by logged user and channel is valid.
		*	redirect to my channel.
		*/
		if ($this->Assets->hasSession() && $channel_owner_id === $session_user_id && $this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
		{
			return redirect()->to('/mychannel');
		}
		else
		{
			if ($this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
			{
				$data = [
					'title'            => $firstname . ' ' . $lastname . '\'s Channel' . $this->web_title,
					'firstname'        => $firstname,
					'lastname'         => $lastname,
					'channel_owner_id' => $channel_owner_id,
					'is_subscribed'    => $this->subscriptions->is_subscribed($channel_owner_id, $session_user_id),
					'user_details'     => $this->users->user_details($channel_owner_id),
				];

				return view('channels/userschannel', $data);
			}

			return redirect()->to('/');
		}
	}

	public function userwall()
	{
		if ($this->request->isAjax())
		{
			$uri                    = explode('/', uri_string());
			$channel_owner_id       = $uri[1];
			$channel_owner_fullname = explode('_', $uri[2]);
			$firstname              = $channel_owner_fullname[0];
			$lastname               = $channel_owner_fullname[1];

			if ($this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
			{
				$data = [
					'channel_owner_id' => $channel_owner_id,
					'firstname'        => $firstname,
					'lastname'         => $lastname,
				];

				return view('channels/userchannel/userwall', $data);
			}
		}
	}

	public function createuserwallpost()
	{
		if ($this->request->isAjax())
		{
			$uri                    = explode('/', uri_string());
			$channel_owner_id       = $uri[1];
			$channel_owner_fullname = explode('_', $uri[2]);
			$firstname              = $channel_owner_fullname[0];
			$lastname               = $channel_owner_fullname[1];

			if ($this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
			{
				$poster_id = $this->Assets->getUserId($this->Assets->getSession('username'));
				$post      = $this->request->getPostGet('post');
				$data      = [
					'wall_owner_id' => $channel_owner_id,
					'poster_id'     => $poster_id,
					'post'          => $post,
					'approved'      => 0,
				];

				if ($this->walls->insert_wallpost($data))
				{
					echo 'ok';
				}
			}
		}
	}

	public function userwallposts()
	{
		if ($this->request->isAjax())
		{
			$uri                    = explode('/', uri_string());
			$channel_owner_id       = $uri[1];
			$channel_owner_fullname = explode('_', $uri[2]);
			$firstname              = $channel_owner_fullname[0];
			$lastname               = $channel_owner_fullname[1];

			if ($this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
			{
				$data = [
					'firstname'        => $firstname,
					'lastname'         => $lastname,
					'channel_owner_id' => $channel_owner_id,
					'userwalls'        => $this->walls->get_user_posts($channel_owner_id),
					'walls'            => $this->walls,
				];

				return view('channels/userchannel/loaduserwallposts', $data);
			}
		}
	}

	public function moreuserwallposts()
	{
		if ($this->request->isAjax())
		{
			$uri                    = explode('/', uri_string());
			$channel_owner_id       = $uri[1];
			$channel_owner_fullname = explode('_', $uri[2]);
			$firstname              = $channel_owner_fullname[0];
			$lastname               = $channel_owner_fullname[1];

			if ($this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
			{
				$offset = $this->request->getPostGet('offset');
				$data   = [
					'channel_owner_id' => $channel_owner_id,
					'userwalls'        => $this->walls->user_more_post($channel_owner_id, $offset),
					'walls'            => $this->walls,
				];

				return view('channels/userchannel/loadmoreuserwallposts', $data);
			}
		}
	}

	public function userdeletepost()
	{
		if ($this->request->isAjax())
		{
			$uri                    = explode('/', uri_string());
			$channel_owner_id       = $uri[1];
			$channel_owner_fullname = explode('_', $uri[2]);
			$firstname              = $channel_owner_fullname[0];
			$lastname               = $channel_owner_fullname[1];

			if ($this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
			{
				$post_id   = $this->request->getPostGet('post_id');
				$poster_id = $this->Assets->getUserId($this->Assets->getSession('username'));

				if ($this->walls->is_your_post($post_id, $poster_id) && $this->walls->delete_post($post_id))
				{
					echo 'ok';
				}
			}
		}
	}

	public function updateuserpost()
	{
		if ($this->request->isAjax())
		{
			$uri                    = explode('/', uri_string());
			$channel_owner_id       = $uri[1];
			$channel_owner_fullname = explode('_', $uri[2]);
			$firstname              = $channel_owner_fullname[0];
			$lastname               = $channel_owner_fullname[1];

			if ($this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
			{
				$poster_id = $this->request->getPostGet('poster_id');
				$post_id   = $this->request->getPostGet('post_id');
				$post      = $this->Assets->filter_tags($this->request->getPostGet('post'));

				if ($this->walls->is_your_post($post_id, $poster_id) && $this->walls->update_user_post($channel_owner_id, $poster_id, $post_id, $post))
				{
					echo $post;
				}
			}
		}
	}

	public function uservideos()
	{
		if ($this->request->isAjax())
		{
			$uri                    = explode('/', uri_string());
			$channel_owner_id       = $uri[1];
			$channel_owner_fullname = explode('_', $uri[2]);
			$firstname              = $channel_owner_fullname[0];
			$lastname               = $channel_owner_fullname[1];

			if ($this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
			{
				$data = [
					'channel_owner_id' => $channel_owner_id,
					'firstname'        => $firstname,
					'lastname'         => $lastname,
					'videos'           => $this->channels->mychannel_videos($channel_owner_id),
				];

				return view('channels/userchannel/uservideos', $data);
			}
		}
	}

	public function uservideosmore()
	{
		if ($this->request->isAjax())
		{
			$uri                    = explode('/', uri_string());
			$channel_owner_id       = $uri[1];
			$channel_owner_fullname = explode('_', $uri[2]);
			$firstname              = $channel_owner_fullname[0];
			$lastname               = $channel_owner_fullname[1];

			if ($this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
			{
				$offset         = $this->request->getPostGet('offset');
				$data['videos'] = $this->channels->load_more_videos($channel_owner_id, $offset);

				return view('channels/userchannel/loadmoreuservideos', $data);
			}
		}
	}

	public function usersubscribe()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$uri                    = explode('/', uri_string());
			$channel_owner_id       = $uri[1];
			$channel_owner_fullname = explode('_', $uri[2]);
			$firstname              = $channel_owner_fullname[0];
			$lastname               = $channel_owner_fullname[1];

			if ($this->users->is_valid_user_channel($channel_owner_id, $firstname, $lastname))
			{
				$subscribe     = $this->request->getPostGet('subscribe');
				$subscriber_id = $this->Assets->getUserId($this->Assets->getSession('username'));

				if ($subscribe)
				{
					if ($this->subscriptions->add_subscriber($channel_owner_id, $subscriber_id))
					{
						echo 'ok';
					}
				}
				else
				{
					if ($this->subscriptions->remove_subscriber($channel_owner_id, $subscriber_id))
					{
						echo 'ok';
					}
				}
			}
		}
	}
}
