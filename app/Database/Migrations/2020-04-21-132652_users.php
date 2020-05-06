<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
	public function up()
	{
		$this->forge->addfield([
			'id'        => [
				'type'           => 'INT',
				'constraint'     => 255,
				'unassign'       => true,
				'auto_increment' => true,
			],

			'username'  => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
			],

			'password'  => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
			],

			'firstname' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
			],

			'lastname'  => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
			],

			'nickname' => [
				'type' => 'VARCHAR',
				'constraint' => 255
			],

			'picture' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE
			],

			'created_at'   => [
				'type' => 'datetime',
			],

			'last_login' => [
				'type' => 'datetime'
			],

			'updated_at' => [
				'type' => 'datetime',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
