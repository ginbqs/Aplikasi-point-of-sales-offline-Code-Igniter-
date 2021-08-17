<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Units extends Migration
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
			'name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP'
		]);
		// Membuat primary key
		$this->forge->addKey('id', TRUE);
		$this->forge->addField("`deleted_at` datetime NULL"); 

		// Membuat tabel news
		$this->forge->createTable('m_units');
	}

	public function down()
	{
		// menghapus tabel m_products
		$this->forge->dropTable('m_units');
	}
}
