<?php namespace App\Database\Seeds;

class NotificationsSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'user_id' => 1,
                'notification' => '{"type":"subscribe","subscriber_id":3,"channel_owner_firstname":"Victor","channel_owner_lastname":"Caviteno","wall_poster_fullname":"Claire Farron","notification":"Claire Farron Subscribed to your channel."}',
                'unread' => 1,
                'created_at' => '2020-07-01 18:05:39',
                'updated_at' => '2020-07-01 18:05:39',
            ],

            [
                'id' => 2,
                'user_id' => 1,
                'notification' => '{"type":"wall_post","poster_id":3,"channel_owner_firstname":"Victor","channel_owner_lastname":"Caviteno","wall_poster_fullname":"Claire Farron","notification":"Claire Farron posted on your wall."}',
                'unread' => 1,
                'created_at' => '2020-07-01 18:05:46',
                'updated_at' => '2020-07-01 18:05:46',
            ],

            [
                'id' => 3,
                'user_id' => 0,
                'notification' => '{"type":"subscribe","subscriber_id":3,"channel_owner_firstname":"Serah","channel_owner_lastname":"Farron","wall_poster_fullname":"Claire Farron","notification":"Claire Farron Subscribed to your channel."}',
                'unread' => 1,
                'created_at' => '2020-07-01 18:06:12',
                'updated_at' => '2020-07-01 18:06:12',
            ],

            [
                'id' => 4,
                'user_id' => 2,
                'notification' => '{"type":"wall_post","poster_id":3,"channel_owner_firstname":"Serah","channel_owner_lastname":"Farron","wall_poster_fullname":"Claire Farron","notification":"Claire Farron posted on your wall."}',
                'unread' => 1,
                'created_at' => '2020-07-01 18:06:18',
                'updated_at' => '2020-07-01 18:06:18',
            ],

            [
                'id' => 5,
                'user_id' => 2,
                'notification' => '{"type":"subscribe","subscriber_id":4,"channel_owner_firstname":"Serah","channel_owner_lastname":"Farron","wall_poster_fullname":"Yuel Psu","notification":"Yuel Psu Subscribed to your channel."}',
                'unread' => 1,
                'created_at' => '2020-07-01 18:07:27',
                'updated_at' => '2020-07-01 18:07:27',
            ],

            [
                'id' => 6,
                'user_id' => 1,
                'notification' => '{"type":"subscribe","subscriber_id":4,"channel_owner_firstname":"Victor","channel_owner_lastname":"Caviteno","wall_poster_fullname":"Yuel Psu","notification":"Yuel Psu Subscribed to your channel."}',
                'unread' => 1,
                'created_at' => '2020-07-01 18:07:39',
                'updated_at' => '2020-07-01 18:07:39',
            ],
        ];

        foreach ($data as $d)
        {
            $this->db->table('notifications')->insert($d);
        }
    }
}