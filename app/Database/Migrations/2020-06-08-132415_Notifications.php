<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notifications extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'           => [
				'type'           => 'INT',
				'constraint'     => 255,
				'unassign'       => true,
				'auto_increment' => true,
			],

			'user_id'      => [
				'type'       => 'INT',
				'constraint' => 255,
			],

			'notification' => [
				'type' => 'TEXT',
			],

			'unread'       => [
				'type'       => 'INT',
				'constraint' => 1,
			],

			'created_at'   => [
				'type' => 'datetime',
			],

			'updated_at'   => [
				'type' => 'datetime',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('notifications');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('notifications');
	}
}
