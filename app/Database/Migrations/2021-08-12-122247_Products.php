<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
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
			'price'      => [
				'type'           => 'double',
				'default'        => 0,
			],
			'desc' => [
				'type'           => 'TEXT',
				'null'           => true,
			],
			'unit_id' => [
				'type'           => 'INT',
				'unsigned' 		 => TRUE,
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP'
		]);
		// Membuat primary key
		$this->forge->addKey('id', TRUE);
		$this->forge->addField("`deleted_at` datetime NULL"); 

		// Membuat tabel news
		$this->forge->addForeignKey('unit_id', 'm_units', 'id');
		$this->forge->createTable('m_products');
	}

	public function down()
	{
		// menghapus tabel m_products
		$this->forge->dropTable('m_products');
	}
}
