<?php namespace App\Controllers;

use App\Models\NotificationsModel;
use App\Models\ChannelsModel;
use App\Models\SubscriptionsModel;

class Notifications extends BaseController
{
	//Notifications Model Property Global.
	private $notifications;

	//Channels Model Property Global.
	private $channels;

	//Subscriptions Model Property Global.
	private $subscriptions;

	public function __construct()
	{
		parent::__construct();

		//Load Notifications Model.
		$this->notifications = new NotificationsModel();

		//Load Channels Model.
		$this->channels = new ChannelsModel();

		//Load Subscriptions Model.
		$this->subscriptions = new SubscriptionsModel();
	}

	public function create()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$notification_type = $this->request->getPostGet('notification_type');
			$user_id           = $this->Assets->getUserId($this->Assets->getSession('username'));

			switch ($notification_type)
			{
				case 'video_upload':

					//Get Subscribers ids.
					$subscribers = $this->subscriptions->get_subscribers_id($user_id);

					if (count($subscribers) > 0)
					{
						//Video Uploader user id.
						$video_uploader_id = $this->Assets->getUserId($this->Assets->getSession('username'));

						//Video Slug.
						$slug = $this->request->getPostGet('slug');

						//Get Video Title via Slug.
						$title = $this->channels->get_video_title($slug)[0]['title'];

						//Get Video Thumb.
						$thumb = $this->Assets->get_picture();

						//Uploader Fullname.
						$fullname = $this->Assets->get_fullname();

						//Create Notification Message.
						$notification = [
							'type'              => $notification_type,
							'video_uploader_id' => $video_uploader_id,
							'slug'              => $slug,
							'message'           => $fullname . ' uploaded a video. <strong>' . $title . '</strong>',
						];

						$notification = json_encode($notification);

						foreach ($subscribers as $subscriber)
						{
							$this->notifications->insert_notification($subscriber['subscriber_id'], $notification);
						}
					}

				break;

				case 'video_comment':

					//Video owner user_id.
					$video_user_id = $this->request->getPostGet('video_user_id');

					//Commentator user id.
					$commentator_id = $this->request->getPostGet('comentor_id');

					//Video Slug
					$slug = $this->request->getPostGet('slug');

					//Commentator Fullname.
					$fullname = $this->Assets->get_fullname();

					//Video title.
					$video_title = $this->Assets->reduce_title($this->channels->get_video_info($slug)['title']);

					if ($video_user_id !== $commentator_id)
					{
						$notification = [
							'type'           => $notification_type,
							'commentator_id' => $commentator_id,
							'slug'           => $slug,
							'message'        => $fullname . ' commented to your video <strong>' . $video_title . '</strong>',
						];

						$notification = json_encode($notification);

						$this->notifications->insert_notification($video_user_id, $notification);
					}
				break;

				case 'my_wallpost':

					//Get User id.
					$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

					//User's Fullname.
					$fullname = explode(' ', $this->Assets->get_fullname());

					//User's Fullname
					$firstname = $fullname[0];

					//User's Lastname.
					$lastname = $fullname[1];

					//Get Subscribers ids.
					$subscribers = $this->subscriptions->get_subscribers_id($user_id);

					//Create Notification Message.
					$notification = [
						'type'      => $notification_type,
						'user_id'   => $user_id,
						'firstname' => $firstname,
						'lastname'  => $lastname,
						'message'   => '<strong>' . $firstname . ' ' . $lastname . '</strong> posted in his/her wall.',
					];

					$notification = json_encode($notification);

					foreach ($subscribers as $subscriber)
					{
						$this->notifications->insert_notification($subscriber['subscriber_id'], $notification);
					}
				break;

				case 'wall_post':

					//Poster user id.
					$poster_id = $this->Assets->getUserId($this->Assets->getSession('username'));

					//Channel owner id.
					$channel_ownner_id = $this->request->getPostGet('channel_owner_id');

					//Channel owner firstname.
					$channel_owner_firstname = $this->request->getPostGet('channel_owner_firstname');

					//Channel owner lastname.
					$channel_owner_lastname = $this->request->getPostGet('channel_owner_lastname');

					//Wall poster Fullname.
					$fullname = $this->Assets->get_fullname();

					$notification = [
						'type'                    => $notification_type,
						'poster_id'               => $poster_id,
						'channel_owner_firstname' => $channel_owner_firstname,
						'channel_owner_lastname'  => $channel_owner_lastname,
						'wall_poster_fullname'    => $fullname,
						'notification'            => $fullname . ' posted on your wall.',
					];

					$notification = json_encode($notification);

					$this->notifications->insert_notification($channel_ownner_id, $notification);
				break;

				case 'subscribe':

					//Subscriber user id.
					$subscriber_id = $this->Assets->getUserId($this->Assets->getSession('username'));

					//Channel owner id.
					$channel_ownner_id = $this->request->getPostGet('channel_owner_id');

					//Channel owner firstname.
					$channel_owner_firstname = $this->request->getPostGet('channel_owner_firstname');

					//Channel owner lastname.
					$channel_owner_lastname = $this->request->getPostGet('channel_owner_lastname');

					//Wall poster Fullname.
					$fullname = $this->Assets->get_fullname();

					$notification = [
						'type'                    => $notification_type,
						'subscriber_id'           => $subscriber_id,
						'channel_owner_firstname' => $channel_owner_firstname,
						'channel_owner_lastname'  => $channel_owner_lastname,
						'wall_poster_fullname'    => $fullname,
						'notification'            => $fullname . ' Subscribed to your channel.',
					];

					$notification = json_encode($notification);

					$this->notifications->insert_notification($channel_ownner_id, $notification);
				break;
			}
		}
	}

	public function check()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

			echo $this->notifications->has_notification($user_id);
		}
	}

	public function update()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));

			if ($this->notifications->mark_as_readed($user_id))
			{
				echo 'ok';
			}
		}
	}

	public function get()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));
			$data    = [
				'user_id'       => $user_id,
				'notifications' => $this->notifications->get_notification($user_id),
			];

			return view('notifications/notification', $data);
		}
	}

	public function clear()
	{
		if ($this->request->isAjax() && $this->Assets->hasSession())
		{
			$user_id = $this->Assets->getUserId($this->Assets->getSession('username'));
			$this->notifications->clear_all($user_id);
		}
	}
}
