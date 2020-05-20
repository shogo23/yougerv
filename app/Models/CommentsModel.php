<?php namespace App\Models;

use Codeigniter\Model;

class CommentsModel extends Model
{
	protected $table         = 'comments';
	protected $primaryKey    = 'id';
	protected $useTimestamps = true;
	protected $allowedFields = [
		'user_id',
		'video_id',
		'video_slug',
		'comment',
	];

	public function is_comment_author($user_id, $comment_id)
	{
		$comments = $this->where('user_id', $user_id)
					->where('id', $comment_id)
					->findAll();

		$count = 0;

		foreach ($comments as $comment)
		{
			$count++;
		}

		if ($count > 0)
		{
			return true;
		}

		return false;
	}

	public function _countAll($video_id, $slug)
	{
		return $this->where('video_id', $video_id)
					->where('video_slug', $slug)
					->countAllResults();
	}

	public function get($video_id, $slug, $page)
	{
		return $this->select(['id', 'user_id', 'comment', 'created_at'])
					->where('video_id', $video_id)
					->where('video_slug', $slug)
					->orderBy('id', 'DESC')
					->limit($page)
					->find();
	}

	public function _insert($data)
	{
		return $this->insert($data);
	}

	public function _delete($video_id, $slug, $comment_id)
	{
		return $this->where('video_id', $video_id)
					->where('video_slug', $slug)
					->where('id', $comment_id)
					->delete();
	}
}
