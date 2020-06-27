<?php namespace App\Controllers;

use App\Models\ChannelsModel;
use App\Models\SubscriptionsModel;

class Home extends BaseController
{
	//ChannelsModel Property Global.
	private $channels;

	public function __construct()
	{
		parent::__construct();

		//Load ChannelsModel.
		$this->channels = new ChannelsModel();

		//Load Subscriptions Model.
		$this->subscriptions = new SubscriptionsModel();
	}

	public function index()
	{
		if (! $this->Assets->hasSession())
		{
			$data = [
				'title' => 'Home' . $this->web_title,
				'videos' => $this->channels->homepage_videos(),
				'pagination_visibility' => $this->channels->pagination_visibility(),
				'pager' => $this->channels->pager,
			];
		}
		else
		{
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));
			$data = [
				'title' => 'Home' . $this->web_title,
				'videos' => $this->channels->homepage_videos(),
				'subscriptions' => $this->subscriptions->get_all_subscriptions($user_id),
				'pagination_visibility' => $this->channels->pagination_visibility(),
				'pager' => $this->channels->pager,
			];
		}

		return view('home/home', $data);
	}

	public function out()
	{
		if ($this->request->getGet() && $this->request->getPostGet('redirect') !== '')
		{
			$link = urlencode($this->request->getPostGet('redirect'));
			$data = [
				'title' => 'Redirect to' . $this->web_title,
				'link'  => $link,
			];

			return view('home/out', $data);
		}
		else
		{
			return redirect()->to('/');
		}
	}

	public function notfound()
	{
		$data = [
			'title' => '404 Not Found' . $this->web_title,
		];

		echo view('home/notfound', $data);
	}
}
