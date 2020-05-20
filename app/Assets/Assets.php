<?php namespace App\Assets;

class Assets extends AssetsBase
{

	//Path to profile pictures and thumbnail.
	private $pathtopicture   = './img/users/pictures/';
	private $pathtothumbnail = './img/users/thumbs/';

	public function getUserId($username)
	{
		$builder = $this->db->table('users');
		$builder->select('id');
		$builder->where('username', $this->session->get('username'));
		$query = $builder->get();
		$id    = 0;

		foreach ($query->getResult() as $user)
		{
			$id += $user->id;
		}

		return $id;
	}

	public function randomstr($length = 15)
	{
		return substr(sha1(rand()), 0, $length);
	}

	public function hasSession()
	{
		if ($this->session->get('username'))
		{
			return true;
		}

		return false;
	}

	public function getSession($str)
	{
		return $this->session->get($str);
	}

	public function setSession(array $str)
	{
		$this->session->set($str);
	}

	public function sessionDestroy()
	{
		$this->session->destroy();
	}

	public function getDateTime()
	{
		return $this->_datetime();
	}

	public function get_fullname($user_id = NULL)
	{
		if ($user_id === NULL) 
		{
			$builder = $this->db->table('users');
			$builder->select(['firstname', 'lastname']);
			$builder->where('username', $this->getSession('username'));
			$query = $builder->get();
		}
		else
		{
			$builder = $this->db->table('users');
			$builder->select(['firstname', 'lastname']);
			$builder->where('id', $user_id);
			$query = $builder->get();
		}
		
		$fullname = '';

		foreach ($query->getResult() as $user)
		{
			$fullname = $user->firstname . ' ' . $user->lastname;
		}

		return $fullname;
	}

	public function get_nickname()
	{
		$builder = $this->db->table('users');
		$builder->select('nickname');
		$builder->where('username', $this->getSession('username'));
		$query    = $builder->get();
		$nickname = '';

		foreach ($query->getResult() as $user)
		{
			$nickname = $user->nickname;
		}

		return $nickname;
	}

	public function imageUploadResize($tmp, $filename, $filetype)
	{
		switch ($filetype) {
			case 'image/jpeg':
				list($width, $height) = getimagesize($tmp);
				$image                = imagecreatetruecolor(250, 250);
				$image_src            = imagecreatefromjpeg($tmp);
				imagecopyresampled($image, $image_src, 0, 0, 0, 0, 250, 250, $width, $height);
				imagejpeg($image, $this->pathtopicture . $filename);

				$thumb_image     = imagecreatetruecolor(70, 70);
				$thumb_image_src = imagecreatefromjpeg($tmp);
				imagecopyresampled($thumb_image, $thumb_image_src, 0, 0, 0, 0, 70, 70, $width, $height);
				imagejpeg($thumb_image, $this->pathtothumbnail . $filename);
			break;

			case 'image/png':
				list($width, $height) = getimagesize($tmp);
				$image                = imagecreatetruecolor(250, 250);
				$image_src            = imagecreatefrompng($tmp);
				imagecopyresampled($image, $image_src, 0, 0, 0, 0, 250, 250, $width, $height);
				imagejpeg($image, $this->pathtopicture . $filename);

				$thumb_image     = imagecreatetruecolor(70, 70);
				$thumb_image_src = imagecreatefrompng($tmp);
				imagecopyresampled($thumb_image, $thumb_image_src, 0, 0, 0, 0, 70, 70, $width, $height);
				imagejpeg($thumb_image, $this->pathtothumbnail . $filename);
			break;
		}

		$user_id = $this->getUserId($this->session->get('username'));
		$picture = '';

		/*
		*   Check if userpicture is already exists.
		*/
		$builder = $this->db->table('users');
		$builder->select('picture');
		$builder->where('id', $user_id);
		$query = $builder->get();

		foreach ($query->getResult() as $user)
		{
			$picture = $user->picture;
		}

		//Delete Picture file if exists.
		if ($picture !== null && $picture !== '')
		{
			$this->removeImage($this->pathtopicture . $picture);
			$this->removeImage($this->pathtothumbnail . $picture);
		}

		//Update User's Record.
		$builder = $this->db->table('users');
		$builder->set([
			'picture'    => $filename,
			'updated_at' => $this->_datetime(),
		]);
		$builder->where('id', $user_id);
		$builder->update();

		return $filename;
	}

	public function has_picture()
	{
		//Get User's Picture filename.
		$builder = $this->db->table('users');
		$builder->select('picture');
		$builder->where('id', $user_id);
		$query   = $builder->get();
		$picture = '';

		foreach ($query->getResult() as $user)
		{
			$picture = $user->picture;
		}

		if ($picture !== null || $picture !== '')
		{
			return true;
		}

		return false;
	}

	public function get_thumbnail($user_id = NULL)
	{
		if ($user_id === NULL)
		{
			$builder = $this->db->table('users');
			$builder->select('picture');
			$builder->where('username', $this->getSession('username'));
			$query   = $builder->get();
		}
		else 
		{
			$builder = $this->db->table('users');
			$builder->select('picture');
			$builder->where('id', $user_id);
			$query   = $builder->get();
		}

		$picture = '';

		foreach ($query->getResult() as $user)
		{
			$picture = $user->picture;
		}

		if ($picture !== null && $picture !== '')
		{
			return '/img/users/thumbs/' . $picture;
		}

		return '/img/nopic.png';
	}

	public function deletePictures($user_id)
	{
		//Get User's Picture filename.
		$builder = $this->db->table('users');
		$builder->select('picture');
		$builder->where('id', $user_id);
		$query   = $builder->get();
		$picture = '';

		foreach ($query->getResult() as $user)
		{
			$picture = $user->picture;
		}

		//Delete Picture Files.
		$this->removeImage($this->pathtopicture . $picture);
		$this->removeImage($this->pathtothumbnail . $picture);

		//Update database record.
		$builder = $this->db->table('users');
		$builder->set('picture', null);
		$builder->where('id', $user_id);
		$builder->update();

		return true;
	}

	public function get_file_ext($filename)
	{
		$exts = explode('.', $filename);
		$ext = end($exts);

		return $ext;
	}

	public function is_valid_video($ext)
	{
		$exts = [
			'mp4', 'm4a', 'm4v', 'f4v', 'f4a', 'm4b', 'm4r', 'f4b', 'mov', '3gp', '3gp2', '3gpp', '3gpp2', 
            'ogg',  'oga', 'ogv', 'ogx', 'wmv', 'wma', 'asf', 'webm', 'flv', 'avi', 'rm', 'mpg', 'mpeg', 'vob'
		];

		if (in_array($ext, $exts))
		{
			return true;
		}

		return false;
	}

	public function video_duration($seconds_count)
    {
        $delimiter  = ':';
        $seconds = $seconds_count % 60;
        $minutes = floor($seconds_count/60);
        $hours   = floor($seconds_count/3600);

        $seconds = str_pad($seconds, 2, "0", STR_PAD_LEFT);
        $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT).$delimiter;

        if ($hours > 0)
        {
            $hours = str_pad($hours, 2, "0", STR_PAD_LEFT).$delimiter;
        }
        else
        {
            $hours = '';
        }

        return $hours . $minutes . $seconds;
	}

	public function reduce_title($title)
	{
		if (strlen($title) > 45)
		{
			$title = substr($title, 0, 45) . '...';
		}

		return $title;
	}
	
	public function get_last_uri() 
	{
		$uri = explode('/', uri_string());
		$count = count($uri);

		return $uri[$count - 1];
	}

	public function when($datetime)
	{
		$second = 1;
        $minute = 60 * $second;
        $hour = 60 * $minute;
        $day = 24 * $hour;
        
        $current = time() - strtotime($datetime);
        
		if ($current < 1 * $minute) 
		{
            return 'About few seconds ago.';
        }
        
		if ($current < 1 * $minute) 
		{
            return 'About a minute ago';
        }
        
		if ($current < 60 * $minute) 
		{
            return floor($current / $minute) . ' minutes ago.';
        }
        
		if ($current < 119 * $minute) 
		{
            return 'About an hour ago';
        }
        
		if ($current < 24 * $hour) 
		{
            return floor($current / $hour) . ' hours ago.';
        }
        
		if ($current < 60 * $hour) 
		{
            return 'About a day ago.';
        }
        
		if ($current < 30 * $day) 
		{
            return floor($current / $day) . ' days ago.';
		} 
		else
		{
            return 'Posted on: ' . date('M j, Y h:i:a', strtotime($datetime));
        }
	}

	public function filter_tags($str)
	{	
		//Strip html tags except <br> and <a>
		$str = 
		$str = strip_tags(nl2br($str), '<br> <br /> <a>');

		//Convert http://<strings> in clickable hyperlink.
		$pattern = '@(http(s)?://)?(([a-zA-Z0-9])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
   		$str = preg_replace($pattern, '<a target="_blank" href="http$2://$3">$0</a>', $str);

		return $str;
	}
}
