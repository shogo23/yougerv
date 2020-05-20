<?php namespace App\Database\Seeds;

class CommentSeeder extends \Codeigniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'user_id' => 2,
                'video_id' => 4,
                'video_slug' => '-uPTS0LGxJ8rCTP',
                'comment' => 'Cool!',
                'created_at' => '2020-05-20 00:45:22',
                'updated_at' => '2020-05-20 00:45:22',
            ],

            [
                'id' => 2,
                'user_id' => 2,
                'video_id' => 1,
                'video_slug' => 'occuzTVyOY80XsH',
                'comment' => 'Hello People!',
                'created_at' => '2020-05-20 00:46:29',
                'updated_at' => '2020-05-20 00:46:29',
            ],

            [
                'id' => 3,
                'user_id' => 2,
                'video_id' => 10,
                'video_slug' => 'vn-Og68ovbbjU4F',
                'comment' => 'Hello People!',
                'created_at' => '2020-05-20 00:46:29',
                'updated_at' => '2020-05-20 00:46:29',
            ],

            [
                'id' => 4,
                'user_id' => 1,
                'video_id' => 6,
                'video_slug' => 'WN_yvhE87K17AtD',
                'comment' => 'Hello Peeps!',
                'created_at' => '2020-05-20 02:54:00',
                'updated_at' => '2020-05-20 02:54:00',
            ],

            [
                'id' => 5,
                'user_id' => 1,
                'video_id' => 1,
                'video_slug' => 'occuzTVyOY80XsH',
                'comment' => 'Hi Serah!',
                'created_at' => '2020-05-20 02:54:40',
                'updated_at' => '2020-05-20 02:54:40',
            ],

            [
                'id' => 6,
                'user_id' => 1,
                'video_id' => 4,
                'video_slug' => '-uPTS0LGxJ8rCTP',
                'comment' => 'Nice!',
                'created_at' => '2020-05-20 02:55:24',
                'updated_at' => '2020-05-20 02:55:24',
            ],
        ];

        foreach ($data as $d)
        {
            $this->db->table('comments')->insert($d);
        }
    }
}