<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cashiers extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'invoice'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
			'original_total'      => [
				'type'           => 'double',
				'default'        => 0,
			],
			'total'      => [
				'type'           => 'double',
				'default'        => 0,
			],
			'pay'      => [
				'type'           => 'double',
				'default'        => 0,
			],
			'changes'      => [
				'type'           => 'double',
				'default'        => 0,
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP'
		]);
		// Membuat primary key
		$this->forge->addKey('id', TRUE);
		$this->forge->addField("`deleted_at` datetime NULL"); 

		// Membuat tabel news
		$this->forge->createTable('t_cashier');
	}

	public function down()
	{
		// menghapus tabel t_cashier
		$this->forge->dropTable('t_cashier');
	}
}
