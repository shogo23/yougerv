<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Walls extends Migration
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

			'wall_owner_id'    => [
				'type'       => 'INT',
				'constraint' => 255,
			],

			'poster_id' 	 => [
				'type'       => 'INT',
				'constraint' => 255,
			],

			'post' 		=> [
				'type' => 'LONGTEXT',
			],

			'approved'	=> [
				'type' 		 => 'INT',
				'constraint' => 1,
			],

			'created_at' => [
				'type' => 'datetime',
			],

			'updated_at' => [
				'type' => 'datetime',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('walls');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('walls');
	}
}
