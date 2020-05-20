<?php namespace App\Models;

use Codeigniter\Model;

class LikesModel extends Model
{
    protected $table         = 'likes';
	protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
		'user_id',
        'video_id',
        'video_slug',
    ];
    
    public function alreadyliked($video_id, $slug, $user_id)
    {
        $likes = $this->where('user_id', $user_id)
                ->where('video_id', $video_id)
                ->where('video_slug', $slug)
                ->countAllResults();

        if ($likes > 0)
        {
            return false;
        }

        return true;
    }

    public function add_like($video_id, $slug, $user_id)
    {
        $this->insert([
            'user_id' => $user_id,
            'video_id' => $video_id,
            'video_slug' => $slug,
        ]);
    }
}