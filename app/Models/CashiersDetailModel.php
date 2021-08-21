<?php

namespace App\Models;

use CodeIgniter\Model;

class CashiersDetailModel extends Model
{
    protected $table      = 't_cashier_detail';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['product_id','qty','original_price','price','original_subtotal','subtotal'];

    protected $column_order = [NULL,'product_id','qty','original_price','price','original_subtotal','subtotal'] ;
    protected $column_select = ['m_products.name','m_units.name as m_units_name','t_cashier_detail.id','t_cashier_detail.product_id','t_cashier_detail.qty','t_cashier_detail.original_price','t_cashier_detail.price','t_cashier_detail.original_subtotal','t_cashier_detail.subtotal'];
    protected $column_search = ['m_products.name','m_units.name','t_cashier_detail.product_id','t_cashier_detail.qty','t_cashier_detail.original_price','t_cashier_detail.price','t_cashier_detail.original_subtotal','t_cashier_detail.subtotal'];
    protected $order = ['m_products.name' => 'ASC'];

    public $db;
    public $builder;
 
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    private function _get_datatables_query($id)
    {
         
       
         $this->builder = $this->db->table($this->table);
         //jika ingin join formatnya adalah sebagai berikut :
         $this->builder->join('m_products','t_cashier_detail.product_id = m_products.id','inner');
         $this->builder->join('m_units','m_products.unit_id = m_units.id','left');
         //end Join
         $i = 0;
     
         foreach ($this->column_search as $item) {
             if ($_POST['search']['value']) {
     
                 if ($i === 0) {
                     $this->builder->groupStart();
                     $this->builder->like($item, $_POST['search']['value']);
                 } else {
                     $this->builder->orLike($item, $_POST['search']['value']);
                 }
     
                 if (count($this->column_search) - 1 == $i)
                     $this->builder->groupEnd();
             }
             $i++;
         }
     
         if (isset($_POST['order'])) {
             $this->builder->orderBy($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
         } else if (isset($order)) {
             $order = $order;
             $this->builder->orderBy(key($this->order), $this->order[key($order)]);
         }
    }

    function get_datatables($id)
    {
        $this->_get_datatables_query($id);
        $this->builder->select(implode(',',$this->column_select));

         if ($_POST['length'] != -1)
             $this->builder->limit($_POST['length'], $_POST['start']);

         $this->builder->where('cashier_id',$id);
         $query = $this->builder->get();
         return $query->getResult();
    }
 
    function count_filtered($id)
    {
        $this->_get_datatables_query($id);
        $this->builder->select("count(*) as total");
        $this->builder->where('cashier_id',$id);
        $query = $this->builder->get();
        return $query->getRow()->total;
    }
 
    public function count_all($id)
    {
        $this->builder = $this->db->table($this->table);
        $this->builder->select("count(*) as total");
        $this->builder->where('cashier_id',$id);
        $query = $this->builder->get();
        return $query->getRow()->total;
    }
}