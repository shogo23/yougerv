<?php namespace App\Database\Seeds;

class UsersSeeder extends \Codeigniter\Database\Seeder
{
	public function run()
	{
		$data = [
			[
				'id'         => 1,
				'username'   => 'gervic23',
				'password'   => '$2y$10$0WYeQPZ.XJOEus.1YCaDXO/.R82/Z93QzXtNuZrWgIX8pcBUuVWcy',
				'firstname'  => 'Victor',
				'lastname'   => 'Caviteno',
				'nickname'   => 'Gervic',
				'picture'    => '3cc51453a6adee892cdf.jpg',
				'created_at' => '2020-05-06 05:06:58',
				'last_login' => '2020-05-16 12:51:04',
				'updated_at' => '2020-05-15 23:51:04',
			],

			[
				'id'         => 2,
				'username'   => 'serah23',
				'password'   => '$2y$10$xhHHZYCNN2qVfJCAWok4auGThV1aVYo07blXmjaSBcp7t259QMnli',
				'firstname'  => 'Serah',
				'lastname'   => 'Farron',
				'nickname'   => 'Serah',
				'picture'    => 'df58d895e679c34eae0e.jpg',
				'created_at' => '2020-05-20 00:03:15',
				'last_login' => '0000-00-00 00:00:00',
				'updated_at' => '2020-05-20 13:44:41',
			],
		];

		foreach ($data as $d)
		{
			$this->db->table('users')->insert($d);
		}
	}
}
