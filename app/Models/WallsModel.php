<?php namespace App\Models;

use Codeigniter\Model;

class WallsModel extends Model
{
	protected $table         = 'walls';
	protected $primaryKey    = 'id';
	protected $useTimestamps = true;
	protected $allowedFields = [
		'wall_owner_id',
		'poster_id',
		'post',
		'approved',
	];

	public function insert_wallpost($data)
	{
		$this->insert($data);

		return true;
	}

	public function get_posts($user_id)
	{
		return $this->select([
			'users.firstname',
			'users.lastname',
			'walls.id',
			'walls.wall_owner_id',
			'walls.poster_id',
			'walls.post',
			'walls.approved',
			'walls.created_at',
		])
					->join('users', 'users.id = walls.poster_id', 'LEFT')
					->where('walls.wall_owner_id', $user_id)
					->orderBy('walls.created_at', 'DESC')
					->limit(10)
					->find();
	}

	public function more_posts($user_id, $offset)
	{
		return $this->select([
			'users.firstname',
			'users.lastname',
			'walls.id',
			'walls.wall_owner_id',
			'walls.poster_id',
			'walls.post',
			'walls.approved',
			'walls.created_at',
		])
			->join('users', 'users.id = walls.poster_id', 'LEFT')
			->where('walls.wall_owner_id', $user_id)
			->orderBy('walls.created_at', 'DESC')
			->limit(10, $offset)
			->find();
	}

	public function is_wall_owner($user_id, $post_id)
	{
		$walls = $this->where('wall_owner_id', $user_id)
					  ->where('id', $post_id)
					  ->countAllResults();

		if ($walls > 0)
		{
			return true;
		}

		return false;
	}

	public function is_your_post($wall_id, $user_id)
	{
		$walls = $this->where('id', $wall_id)
					  ->where('poster_id', $user_id)
					  ->countAllResults();

		if ($walls > 0)
		{
			return true;
		}

		return false;
	}

	public function is_post_belongs_to_your_wall($wall_owner_id, $post_id)
	{
		$walls = $this->where('wall_owner_id', $wall_owner_id)
					  ->where('id', $post_id)
					  ->countAllResults();

		if ($walls > 0)
		{
			return true;
		}

		return false;
	}

	public function approve_post($post_id)
	{
		$this->where('id', $post_id)
			 ->set('approved', 1)
			 ->update();

		return true;
	}

	public function update_owner_post($user_id, $post_id, $post)
	{
		$this->where('id', $post_id)
			 ->where('wall_owner_id', $user_id)
			 ->set('post', $post)
			 ->update();

		return true;
	}

	public function delete_post($post_id)
	{
		$this->where('id', $post_id)
			 ->delete();

		return true;
	}

	public function get_user_posts($user_id)
	{
		return $this->select([
			'users.firstname',
			'users.lastname',
			'walls.id',
			'walls.wall_owner_id',
			'walls.poster_id',
			'walls.post',
			'walls.approved',
			'walls.created_at',
		])
			->join('users', 'users.id = walls.poster_id', 'LEFT')
			->where('walls.wall_owner_id', $user_id)
			->where('approved', 1)
			->orderBy('walls.created_at', 'DESC')
			->limit(10)
			->find();
	}

	public function user_more_post($user_id, $offset)
	{
		return $this->select([
			'users.firstname',
			'users.lastname',
			'walls.id',
			'walls.wall_owner_id',
			'walls.poster_id',
			'walls.post',
			'walls.approved',
			'walls.created_at',
		])
			->join('users', 'users.id = walls.poster_id', 'LEFT')
			->where('walls.wall_owner_id', $user_id)
			->where('walls.approved', 1)
			->orderBy('walls.created_at', 'DESC')
			->limit(10, $offset)
			->find();
	}

	public function update_user_post($channel_owner_id, $poster_id, $post_id, $post)
	{
		$this->where('id', $post_id)
			 ->where('wall_owner_id', $channel_owner_id)
			 ->where('poster_id', $poster_id)
			 ->set('post', $post)
			 ->update();

		return true;
	}
}
