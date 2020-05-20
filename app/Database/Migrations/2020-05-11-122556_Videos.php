<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Videos extends Migration
{
	public function up()
	{
		$this->forge->addfield([
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

			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => 255
			],

			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => true,
			],

			'description' => [
				'type' => 'LONGTEXT',
				'null' => true,
			],

			'tags' => [
				'type' => 'LONGTEXT',
				'null' => true,
			],

			'orig_filename' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => true,
			],

			'filename' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => true,
			],

			'length' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
			],

			'likes' => [
				'type' => 'INT',
				'constraint' => 255,
				'null' => true,
			],

			'views' => [
				'type' => 'INT',
				'constraint' => 255,
				'null' => true,
			],

			'converted' => [
				'type' => 'INT',
				'constraint' => 1,
				'null' => true
			],

			'created_at' => [
				'type' => 'datetime',
			],

			'updated_at' => [
				'type' => 'datetime',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('videos');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('videos');
	}
}
