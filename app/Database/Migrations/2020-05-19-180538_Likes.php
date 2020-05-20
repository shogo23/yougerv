<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Likes extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 255,
				'unassign' => TRUE,
				'auto_increment' => TRUE,
			],

			'user_id' => [
				'type' => 'INT',
				'constraint' => 255,
			],

			'video_id' => [
				'type' => 'INT',
				'constraint' => 255,
			],

			'video_slug' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
			],

			'created_at' => [
				'type' => 'datetime',
			],

			'updated_at' => [
				'type' => 'datetime',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('likes');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('likes');
	}
}
