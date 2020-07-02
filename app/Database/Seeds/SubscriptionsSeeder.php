<?php namespace App\Database\Seeds;

class SubscriptionsSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'user_id' => 1,
                'subscriber_id' => 3,
                'created_at' => '2020-07-01 18:05:38',
                'updated_at' => '2020-07-01 18:05:38',
            ],

            [
                'id' => 2,
                'user_id' => 2,
                'subscriber_id' => 3,
                'created_at' => '2020-07-01 18:06:12',
                'updated_at' => '2020-07-01 18:06:12',
            ],

            [
                'id' => 3,
                'user_id' => 2,
                'subscriber_id' => 4,
                'created_at' => '2020-07-01 18:07:27',
                'updated_at' => '2020-07-01 18:07:27',
            ],

            [
                'id' => 4,
                'user_id' => 1,
                'subscriber_id' => 4,
                'created_at' => '2020-07-01 18:07:39',
                'updated_at' => '2020-07-01 18:07:39',
            ],
        ];

        foreach ($data as $d)
        {
            $this->db->table('subscriptions')->insert($d);
        }
    }
}