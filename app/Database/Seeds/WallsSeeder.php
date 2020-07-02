<?php namespace App\Database\Seeds;

class WallsSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'wall_owner_id' => 1,
                'poster_id' => 3,
                'post' => 'Hi Victor!',
                'approved' => 0,
                'created_at' => '2020-07-01 18:05:46',
                'updated_at' => '2020-07-01 18:05:46',
            ],

            [
                'id' => 2,
                'wall_owner_id' => 2,
                'poster_id' => 3,
                'post' => 'Hi Serah! :D',
                'approved' => 0,
                'created_at' => '2020-07-01 18:06:18',
                'updated_at' => '2020-07-01 18:06:18',
            ],
        ];

        foreach ($data as $d)
        {
            $this->db->table('walls')->insert($d);
        }
    }
}