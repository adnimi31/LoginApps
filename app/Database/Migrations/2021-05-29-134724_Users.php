<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'foto' => [
				'type' => 'TEXT',
				'null' => false,
			],
			'username'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'password' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'role' => [
				'type'       => 'VARCHAR',
				'constraint' => '10',
			],
			'status' => [
				'type'       => 'VARCHAR',
				'constraint' => '9',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('users');
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
