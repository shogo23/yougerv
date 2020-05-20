<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Comments extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'         => [
				'type'           => 'INT',
				'constraint'     => 255,
				'unassign'       => true,
				'auto_increment' => true,
			],

			'user_id'    => [
				'type'       => 'INT',
				'constraint' => 255,
			],

			'video_id'   => [
				'type'       => 'INT',
				'constraint' => 255,
			],

			'video_slug' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
			],

			'comment'    => [
				'type' => 'TEXT',
			],

			'created_at' => [
				'type' => 'datetime',
			],

			'updated_at' => [
				'type' => 'datetime',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('comments');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('comments');
	}
}
