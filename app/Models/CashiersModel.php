<?php

namespace App\Models;

use CodeIgniter\Model;

class CashiersModel extends Model
{
    protected $table      = 't_cashier';
    protected $primaryKey = 'id';

    protected $useSoftDeletes = true;

    protected $useAutoIncrement = true;
    protected $allowedFields = ['invoice', 'total','pay','changes'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation  = false;

    protected $column_order = [NULL,'invoice', 'total','pay','changes'] ;
    protected $column_select = ['id','invoice', 'total','pay','changes'];
    protected $column_search = ['id','invoice', 'total','pay','changes'];
    protected $order = ['invoice' => 'DESC'];

    public $db;
    public $builder;
 
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    private function _get_datatables_query()
    {
         
       
         $this->builder = $this->db->table($this->table);
         //jika ingin join formatnya adalah sebagai berikut :
         $this->builder->where('t_cashier.deleted_at',NULL);
         $this->builder->select(implode(',',$this->column_select));
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

    function get_datatables()
    {
        $this->_get_datatables_query();
         if ($_POST['length'] != -1)
             $this->builder->limit($_POST['length'], $_POST['start']);
         $query = $this->builder->get();
         return $query->getResult();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->builder->get();
        return $this->builder->countAll();
    }
 
    public function count_all()
    {
        $this->builder->from($this->table);
        return $this->builder->countAll();
    }
    public function getDetail($id)
    {
        $this->builder = $this->db->table($this->table);
        $this->builder->where('t_cashier.id',$id);
        $query = $this->builder->get();
        return $query->getRow();
    }
    public function getTotalCashiers(){
        $this->builder = $this->db->table('t_cashier_detail');
        $this->builder->selectSum('t_cashier_detail.subtotal');
        $this->builder->join('t_cashier','t_cashier.id = t_cashier_detail.cashier_id','inner');
        $this->builder->like('t_cashier.invoice',date("Ym"),'after');
        $query = $this->builder->get();
        return $query->getRow();
    }
    public function getChart(){
        $this->builder = $this->db->table('t_cashier_detail');
        $this->builder->select('sum(t_cashier_detail.subtotal) as total, substring(t_cashier.invoice,1,6) as bulan');
        $this->builder->join('t_cashier','t_cashier.id = t_cashier_detail.cashier_id','inner');
        $this->builder->like('t_cashier.invoice',date("Y"),'after');
        $this->builder->groupBy('bulan');
        $query = $this->builder->get();
        return $query->getResult();
    }
}