<?php namespace App\Models;

use CodeIgniter\Model;

class NotificationsModel extends Model {
    protected $table         = 'notifications';
	protected $primaryKey    = 'id';
	protected $useTimestamps = true;
	protected $allowedFields = [
        'user_id',
        'type',
        'notification',
        'unread',
    ];

    public function insert_notification($reciever_id, $notification)
    {
        $this->insert([
            'user_id' => $reciever_id,
            'notification' => $notification,
            'unread' => 1,
        ]);

        return true;
    }

    public function has_notification($user_id)
    {
        return (int) $this->where('user_id', $user_id)
                          ->where('unread', 1)
                          ->countAllResults();
    }

    public function mark_as_readed($user_id)
    {
        $this->where('user_id', $user_id)
             ->set('unread', 0)
             ->update();

        return true;
    }

    public function get_notification($user_id)
    {
        return $this->select([
            'id',
            'user_id',
            'notification',
            'created_at'
        ])
        ->where('user_id', $user_id)
        ->orderBy('created_at', 'DESC')
        ->find();
    }

    public function clear_all($user_id)
    {
        $this->where('user_id', $user_id)
             ->delete();

        return true;
    }
}