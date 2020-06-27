<?php namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class UsersModel extends Model
{
	protected $table         = 'users';
	protected $primaryKey    = 'id';
	protected $useTimestamps = true;
	protected $allowedFields = [
		'username',
		'password',
		'firstname',
		'lastname',
		'nickname',
		'last_login',
	];
	protected $returnType    = 'App\Entities\User';

	public function _insert($data)
	{
		$user = new User();

		foreach ($data as $d => $v)
		{
			if ($d === 'password')
			{
				$user->setPassword($v);
			}
			else
			{
				$user->$d = $v;
			}
		}

		if ($this->save($user))
		{
			return true;
		}
	}

	public function _update_last_login($username, $datetime)
	{
		$this->where('username', $username)
				->set(['last_login' => $datetime])
				->update();
	}

	public function _getUserData($username)
	{
		$data = $this->select(['username', 'firstname', 'lastname', 'nickname'])
					->where('username', $username)
					->findAll();

		return $data;
	}

	public function user_details($user_id) 
	{
		$users = $this->select(['id', 'firstname', 'lastname', 'created_at'])
					->where('id' , $user_id)
					->find();

		$details = [];

		foreach ($users as $user) 
		{
			$details['user_id'] = $user->id;
			$details['firstname'] = $user->firstname;
			$details['lastname'] = $user->lastname;
			$details['created_at'] = $user->created_at;
		}

		return $details;
	}

	public function is_valid_user_channel($channel_owner_id, $firstname, $lastname) 
	{
		$user = $this->where('id', $channel_owner_id)
					 ->where('firstname', $firstname)
					 ->where('lastname', $lastname)
					 ->countAllResults();

		if ($user > 0)
		{
			return true;
		}

		return false;
	}

	public function search_channel($keywords)
	{
		$keywords = explode(' ', $keywords);
		$i = 0;

		$searchs = $this->select([
			'id', 'firstname', 'lastname', 'created_at'
		]);

		foreach ($keywords as $keyword)
		{
			$i++;

			if ($i == 1)
			{
				$searchs->like('firstname', $keyword);
				$searchs->orLike('lastname', $keyword);
			}
			else
			{
				$searchs->orLike('firstname', $keyword);
				$searchs->orLike('lastname', $keyword);
			}
		}

		$searchs->orderBy('RAND()');
		$searchs->limit(4);

		return $searchs->find();
	}

	public function save_fullname($user_id, $firstname, $lastname)
	{
		$this->where('id', $user_id)
			 ->set([
				'firstname' => $firstname,
				'lastname' => $lastname,
			 ])
			 ->update();

		return true;
	}

	public function save_nickname($user_id, $nickname)
	{
		$this->where('id', $user_id)
			 ->set('nickname', $nickname)
			 ->update();

		return true;
	}

	public function get_hashed_password($user_id)
	{
		$password = '';
		$users = $this->select('password')
					->where('id', $user_id)
					->find();

		foreach ($users as $user)
		{
			$password = $user->password;
		}

		return $password;
	}

	public function update_password($user_id, $password)
	{
		$user = new User();
		$this->where('id', $user_id)
			 ->set('password', $user->hashPassword($password))
			 ->update();

		return true;
	}
}
