<?php namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController 
{

	public function login()
	{
		if (! $this->Assets->hasSession())
		{
			$data = [
				'title'      => 'Login - CI4',
				'validation' => null,
			];

			return view('users/login', $data);
		}
		else
		{
			return redirect()->to('/mychannel');
		}
	}

	public function loginP()
	{
		/*
		*   Validating data.
		*   Check App/Validation/LoginRules.php for additional validating rules.
		*/
		$validation = \Config\Services::validation();

		$validation->setRules([
			'username' => [
				'label'  => 'Username',
				'rules'  => 'required|username_exist[users.username]',
				'errors' => [
					'required'       => '{field} field is required.',
					'username_exist' => 'Username and Password did not matched.',
				],
			],

			'password' => [
				'label'  => 'Password',
				'rules'  => 'required|match_dbpass[users.username]',
				'errors' => [
					'required'     => '{field} is required.',
					'match_dbpass' => 'Username and Password did not match.',
				],
			],
		]);

		$validation->withRequest($this->request);

		if (! $validation->run())
		{
			$data = [
				'title'      => 'Login - CI4',
				'validation' => $validation,
			];

			return view('users/login', $data);
		}
		else
		{
			//Load Model.
			$users = new UsersModel();

			//Update last login.
			$users->_update_last_login($this->request->getPostGet('username'), $this->Assets->getDateTime());

			//Session Data.
			$data = [];

			//Get User's Data.
			foreach ($users->_getUserData($this->request->getPostGet('username')) as $user)
			{
				$data['username']  = $user->username;
				$data['firstname'] = $user->firstname;
				$data['nickname']  = $user->nickname;
			}

			//Set Session.
			$this->Assets->setSession($data);

			//Redirect to MyChannel.
			return redirect()->to('/mychannel');
		}
	}

	public function logout()
	{
		$this->Assets->sessionDestroy();

		return redirect()->to('/login');
	}

	public function register()
	{
		if (! $this->Assets->hasSession())
		{
			$data = [
				'title'      => 'Register - CI4',
				'request'    => null,
				'validation' => null,
			];

			return view('users/register', $data);
		}
		else
		{
			return redirect()->to('/mychannel');
		}
	}

	public function reg()
	{
		helper(['form', 'url']);

		$validation = \Config\Services::validation();

		$validation->setRules([
			'username'         => [
				'label'  => 'Username',
				'rules'  => 'required|is_unique[users.username.password]|max_length[11]|min_length[6]',
				'errors' => [
					'required'   => '{field} is required.',
					'is_unique'  => '{field} is already exist.',
					'max_length' => '{field} length is maximum to 11 characters.',
					'min_length' => '{field} is too short.',
				],
			],

			'password'         => [
				'label'  => 'Password',
				'rules'  => 'required|min_length[6]',
				'errors' => [
					'required'   => '{field} is required.',
					'min_length' => '{field} is too short.',
				],
			],

			'password_confirm' => [
				'label'  => 'Confirm Password',
				'rules'  => 'required|matches[password]',
				'errors' => [
					'required' => 'Please Repeat your {field}.',
					'matches'  => 'Passwords did not match.',
				],
			],

			'firstname'        => [
				'label'  => 'Firstname',
				'rules'  => 'required|min_length[2]|max_length[11]',
				'errors' => [
					'required'   => '{field} is required.',
					'min_length' => '{field} is too short.',
					'max_length' => '{field} length is maximum to 11 characters.',
				],
			],

			'lastname'         => [
				'label'  => 'Lastname',
				'rules'  => 'required|min_length[2]|max_length[11]',
				'errors' => [
					'required'   => '{field} is required.',
					'min_length' => '{field} is too short.',
					'max_length' => '{field} length is maximum to 11 characters.',
				],
			],

			'nickname'         => [
				'label'  => 'Nickname',
				'rules'  => 'required|min_length[2]|max_length[11]',
				'errors' => [
					'required'   => '{field} is required.',
					'min_length' => '{field} is too short.',
					'max_length' => '{field} length is maximum to 11 characters.',
				],
			],
		]);

		$validation->withRequest($this->request);

		if (! $validation->run())
		{
			$data = [
				'title'      => 'Register - CI4',
				'request'    => $this->request->getGetPost(),
				'validation' => $validation,
			];

			return view('users/register', $data);
		}
		else
		{
			$entries = [
				'username'  => $this->request->getPostGet('username'),
				'password'  => $this->request->getPostGet('password'),
				'firstname' => $this->request->getPostGet('firstname'),
				'lastname'  => $this->request->getPostGet('lastname'),
				'nickname'  => $this->request->getPostGet('nickname'),
			];

			$user = new UsersModel();

			if ($user->_insert($entries))
			{
				$sess_data = [
					'username'  => $this->request->getPostGet('username'),
					'firstname' => $this->request->getPostGet('firstname'),
					'lastname'  => $this->request->getPostGet('lastname'),
					'nickname'  => $this->request->getPostGet('nickname'),
				];

				$this->Assets->setSession($sess_data);

				return redirect()->to('/setpicture');
			}
		}
	}

	public function setpicture()
	{
		if ($this->Assets->hasSession())
		{
			$data = [
				'title' => 'Set Picture - CI4',
			];

			return view('users/setpicture', $data);
		}
		else
		{
			return redirect()->to('/');
		}
	}

	public function imageupload()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$size = $_FILES['image']['size'];
			$type = $_FILES['image']['type'];
			$tmp  = $_FILES['image']['tmp_name'];

			$size_allowed = 512 * 1024;

			if ($size <= $size_allowed && ($type === 'image/jpeg' || $type === 'image/png'))
			{
				$filename = $this->Assets->randomstr(20) . '.jpg';

				echo $this->Assets->imageUploadResize($tmp, $filename, $type);
			}
		}
	}

	public function imageremove()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			//Get user_id.
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

			//Delete Picture Files.
			if ($this->Assets->deletePictures($user_id))
			{
				echo 'ok';
			}
		}
	}
}
