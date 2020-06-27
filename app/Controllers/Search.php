<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\ChannelsModel;

class Search extends BaseController
{
	//UsersModel Property Global.
	private $users;

	//ChannelsModel Property Global.
	private $channels;

	public function __construct()
	{
		parent::__construct();

		//Load Users Model.
		$this->users = new UsersModel();

		//Load Channels Model.
		$this->channels = new ChannelsModel();
	}

	public function search()
	{
		$keywords = $this->request->getPostGet('s');

		if (strlen($keywords) > 2)
		{
			$data = [
				'keywords'              => $keywords,
				'title'                 => $keywords . $this->web_title,
				'channels'              => $this->users->search_channel($keywords),
				'videos'                => $this->channels->search_videos($keywords),
				'pagination_visibility' => $this->channels->pagination_visibility($keywords),
				'pager'                 => $this->channels->pager,
			];

			return view('search/search', $data);
		}
		else
		{
			$data = [
				'keywords' => $keywords,
				'title'    => $keywords . $this->web_title,
			];

			return view('search/keywordsshort', $data);
		}
	}
}
