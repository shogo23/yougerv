<?php namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{

	//Users Model Property Global.
	private $users;

	public function __construct()
	{
		parent::__construct();

		//Load UsersModel.
		$this->users = new UsersModel();
	}

	public function login()
	{
		if (! $this->Assets->hasSession())
		{
			$data = [
				'title'      => 'Login' . $this->web_title,
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
			//Update last login.
			$this->users->_update_last_login($this->request->getPostGet('username'), $this->Assets->getDateTime());

			//Session Data.
			$data = [];

			//Get User's Data.
			foreach ($this->users->_getUserData($this->request->getPostGet('username')) as $user)
			{
				$data['username']  = $user->username;
				$data['firstname'] = $user->firstname;
				$data['nickname']  = $user->nickname;
			}

			//Set Session.
			$this->Assets->setSession($data);

			//Redirect.
			if ($this->request->getPostGet('redirect'))
			{
				return redirect()->to('/' . $this->request->getPostGet('redirect'));
			}

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
				'title'      => 'Register' . $this->web_title,
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

			if ($this->users->_insert($entries))
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
		if ($this->Assets->hasSession() && ! $this->Assets->has_picture())
		{
			$data = [
				'title' => 'Set Picture' . $this->web_title,
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

	public function accountsettings()
	{
		if ($this->Assets->hasSession())
		{
			$data = [
				'title'    => 'Account Settings' . $this->web_title,
				'fullname' => $this->Assets->get_fullname(),
				'nickname' => $this->Assets->get_nickname(),
			];

			return view('users/accountsettings', $data);
		}
		else
		{
			return redirect()->to('/');
		}
	}

	public function fullnamesave()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			//User's ID.
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

			//Post requests.
			$firstname = $this->request->getPostGet('firstname');
			$lastname  = $this->request->getPostGet('lastname');

			//Firstname and Lastname length should not exceed 12 characters or more.
			if (strlen($firstname) <= 12 && strlen($lastname) <= 12)
			{
				if ($this->users->save_fullname($user_id, $firstname, $lastname))
				{
					echo 'ok';
				}
			}
		}
	}

	public function nicknamesave()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			//User's ID.
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

			//Post request data.
			$nickname = $this->request->getPostGet('nickname');

			//Nickmame length should not exceed to 12 characters.
			if (strlen($nickname) <= 12)
			{
				if ($this->users->save_nickname($user_id, $nickname))
				{
					echo 'ok';
				}
			}
		}
	}

	public function passwordcheck()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			//User's ID.
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

			//Post request data.
			$password = $this->request->getPostGet('password');

			//Current user's hashed password.
			$hash_password = $this->users->get_hashed_password($user_id);

			if (password_verify($password, $hash_password))
			{
				echo (int) 1;
			}
			else
			{
				echo (int) 0;
			}
		}
	}

	public function passwordsave()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			//User's ID.
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

			//Post request data.
			$password = $this->request->getPostGet('password');

			//Password length should be 6 characters or more.
			if (strlen($password) >= 6)
			{
				if ($this->users->update_password($user_id, $password))
				{
					echo 'ok';
				}
			}
		}
	}
}
