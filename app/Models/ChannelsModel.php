<?php namespace App\Models;

use CodeIgniter\Model;

class ChannelsModel extends Model
{
    protected $table         = 'videos';
	protected $primaryKey    = 'id';
	protected $useTimestamps = true;
	protected $allowedFields = [
		'user_id',
		'slug',
		'title',
		'description',
		'tags',
		'orig_filename',
		'filename',
		'length',
		'cover_image',
		'likes',
		'views',
		'converted',
	];

	public function is_record_exists($slug) 
	{
		$videos = $this->where('slug', $slug)
						->findAll();


		$count = 0;

		foreach ($videos as $video)
		{
			$count++;
		}

		if ($count > 0) 
		{
			return true;
		}

		return false;
	}

	public function create_record($data) 
	{
		$this->save($data);
	}

	public function update_record($data)
	{
		$this->where('user_id', $data['user_id'])
				->where('slug', $data['slug'])
				->set([
					'orig_filename' => $data['orig_filename'],
					'filename' => $data['filename']
				])
				->update();
	}

	public function update_details_record($data)
	{
		$this->where('user_id', $data['user_id'])
				->where('slug', $data['slug'])
				->set([
					'title' => $data['title'],
					'description' => $data['description'],
					'tags' => $data['tags']
				])
				->update();
	}

	public function get_new_filename($slug) 
	{
		$videos = $this->select('filename')
				->where('slug', $slug)
				->findAll();

		$filename = '';

		foreach ($videos as $video) 
		{
			$filename = $video['filename'];
		}
		
		return $filename;
	}

	public function update_record_after_converting($slug, $data = [])
	{
		$this->where('slug', $slug)
				->set($data)
				->update();
	}

	public function slug_exists($slug)
	{
		$builder = $this->db->table('videos');
		$builder->where('slug', $slug);
		$builder->where('converted', 1);
		$query = $builder->get();
		$count = 0;

		foreach ($query->getResult() as $channel)
		{
			$count++;
		}

		if ($count > 0)
		{
			return true;
		}

		return false;
	}

	public function get_video($slug)
	{
		$videos = $this->select([
		'users.firstname',
		'users.lastname',
		'videos.id',
		'videos.user_id',
		'videos.title', 
		'videos.description', 
		'videos.tags', 
		'videos.filename', 
		'videos.likes', 
		'videos.views', 
		'videos.created_at'])
			->join('users', 'users.id = videos.user_id', 'left')
			->where('slug', $slug)
			->where('converted', 1)
			->find();
		
		$data = [];
		$data['slug'] = $slug;

		foreach ($videos as $video)
		{
			$data['firstname'] = $video['firstname'];
			$data['lastname'] = $video['lastname'];
			$data['video_id'] = $video['id'];
			$data['user_id'] = $video['user_id'];
			$data['title'] = $video['title'];
			$data['description'] = $video['description'];
			$data['tags'] = $video['tags'];
			$data['filename'] = $video['filename'];
			$data['likes'] = $video['likes'];
			$data['views'] = $video['views'];
			$data['created_at'] = $video['created_at'];
		}

		return $data;
	}

	public function get_latest_videos($slug) 
	{
		return $this->select([
			'users.firstname',
			'users.lastname',
			'videos.slug',
			'videos.title',
			'videos.length',
			'videos.created_at'
		])
			->join('users', 'users.id = videos.user_id', 'left')
			->where('slug !=', $slug)
			->where('converted', 1)
			->orderBy('created_at', 'DESC')
			->limit(50)
			->find();
	}

	public function view($slug)
	{
		//Get Current View Count.
		$videos = $this->select('views')
				->where('slug', $slug)
				->find();

		$current_views = 0;

		foreach ($videos as $video)
		{
			$current_views += $video['views'];
		}

		//Increment view count.
		$views = $current_views + 1;

		//Update View.
		$this->where('slug', $slug)
			->set('views', $views)
			->update();
	}

	public function update_like($slug)
	{
		//Get Current Likes.
		$videos = $this->select('likes')
				->where('slug', $slug)
				->find();

		$current_likes = 0;

		foreach ($videos as $video)
		{
			$current_likes += $video['likes'];
		}

		//Increment likes.
		$likes = $current_likes + 1;

		//Update Likes.
		$this->where('slug', $slug)
				->set('likes', $likes)
				->update();

		return $likes;
	}
}