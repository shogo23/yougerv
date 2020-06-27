<?php namespace App\Models;

use CodeIgniter\Model;

class SubscriptionsModel extends Model
{
	protected $table         = 'subscriptions';
	protected $primaryKey    = 'id';
	protected $useTimestamps = true;
	protected $allowedFields = [
		'user_id',
		'subscriber_id',
	];

	public function is_subscribed($channel_id, $subscriber_id)
	{
		$subscription = $this->where('user_id', $channel_id)
							 ->where('subscriber_id', $subscriber_id)
							 ->countAllResults();

		if ($subscription > 0)
		{
			return true;
		}

		return false;
	}

	public function add_subscriber($channel_id, $subscriber_id)
	{
		$this->insert([
			'user_id'       => $channel_id,
			'subscriber_id' => $subscriber_id,
		]);

		return true;
	}

	public function remove_subscriber($channel_id, $subscriber_id)
	{
		$this->where('user_id', $channel_id)
			 ->where('subscriber_id', $subscriber_id)
			 ->delete();

		return true;
	}

	public function get_subscribers($user_id)
	{
		return $this->select([
			'subscriptions.subscriber_id',
			'users.firstname',
			'users.lastname',
			'users.created_at',
		])
			->join('users', 'users.id = subscriptions.subscriber_id', 'LEFT')
			->where('subscriptions.user_id', $user_id)
			->orderBy('subscriptions.created_at', 'DESC')
			->find();
	}

	public function get_subscriptions($subscriber_id)
	{
		return $this->select([
			'users.id AS user_id',
			'users.firstname',
			'users.lastname',
			'users.created_at',
		])
		->join('users', 'users.id = subscriptions.user_id', 'LEFT')
		->where('subscriptions.subscriber_id', $subscriber_id)
		->orderBy('subscriptions.created_at', 'DESC')
		->find();
	}

	public function remove_subscription($subscriber_id, $user_id)
	{
		$this->where('subscriber_id', $subscriber_id)
			 ->where('user_id', $user_id)
			 ->delete();

		return true;
	}

	public function get_subscribers_id($user_id)
	{
		return $this->select('subscriber_id')
					->where('user_id', $user_id)
					->find();
	}

	public function get_all_subscriptions($user_id)
	{
		return $this->distinct()
					->select([
						'users.id',
						'users.firstname',
						'users.lastname',
					])
					->join('users', 'subscriptions.user_id = users.id', 'LEFT')
					->join('videos', 'videos.user_id = subscriptions.user_id', 'LEFT')
					->where('subscriptions.subscriber_id', $user_id)
					->where('videos.converted', 1)
					->where('videos.slug !=', null)
					->groupBy('users.id')
					->orderBy('RAND()')
					->limit(4)
					->find();
	}
}
