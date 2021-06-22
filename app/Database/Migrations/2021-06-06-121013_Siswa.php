<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Siswa extends Migration
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
			'nama'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'alamat' => [
				'type' => 'TEXT',
				'null' => false,
			],
			'email' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'nohp' => [
				'type'       => 'VARCHAR',
				'constraint' => '10',
			],
			'status' => [
				'type'       => 'VARCHAR',
				'constraint' => '9',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('siswa');
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
