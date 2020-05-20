<?php namespace App\Database\Seeds;

class MainSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->call('UsersSeeder');
        $this->call('VideoSeeder');
        $this->call('CommentSeeder');
    }
}