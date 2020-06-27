<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Subscriptions extends Migration
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

			'subscriber_id'    => [
				'type'       => 'INT',
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
		$this->forge->createTable('subscriptions');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('subscriptions');
	}
}
