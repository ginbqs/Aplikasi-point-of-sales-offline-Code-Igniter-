<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CashieTemp extends Migration
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
			'product_id'       => [
				'type'           => 'INT',
				'unsigned' 		 => TRUE,
			],
			'qty'       => [
				'type'           => 'INT',
				'constraint'     => '11'
			],
			'price'      => [
				'type'           => 'double',
				'default'        => 0,
			],
			'subtotal'      => [
				'type'           => 'double',
				'default'        => 0,
			]
		]);
		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		$this->forge->addForeignKey('product_id', 'm_products', 'id');

		// Membuat tabel news
		$this->forge->createTable('t_cashier_temp');
	}

	public function down()
	{
		$this->forge->dropTable('t_cashier_temp');
	}
}
