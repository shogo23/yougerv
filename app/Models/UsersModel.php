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
}
