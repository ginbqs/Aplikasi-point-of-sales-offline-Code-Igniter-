<?php

namespace App\Models;

use CodeIgniter\Model;

use \App\Models\CashiersModel;

class CashiersTempModel extends Model
{
    protected $table      = 't_cashier_temp';
    protected $primaryKey = 'id';


    protected $useAutoIncrement = true;
    protected $allowedFields = ['product_id', 'qty','price','subtotal'];
    protected $useTimestamps = false;

    protected $column_order = [NULL,'m_products.name','m_units.name','t_cashier_temp.product_id','t_cashier_temp.qty','t_cashier_temp.price','t_cashier_temp.subtotal'] ;
    protected $column_select = ['m_products.name','m_units.name as m_units_name','t_cashier_temp.id','t_cashier_temp.product_id','t_cashier_temp.qty','t_cashier_temp.price','t_cashier_temp.subtotal'];
    protected $column_search = ['m_products.name','m_units.name','t_cashier_temp.product_id','t_cashier_temp.qty','t_cashier_temp.price','t_cashier_temp.subtotal'];
    protected $order = ['m_products.name' => 'ASC'];

    public $db;
    public $builder;
 
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

     public function getDetail($id)
    {
        $this->builder = $this->db->table($this->table);
        $this->builder->where('product_id',$id);
        $query = $this->builder->get();
        return $query->getRow();
    }
    private function _get_datatables_query()
    {
       
         $this->builder = $this->db->table($this->table);
         //jika ingin join formatnya adalah sebagai berikut :
         $this->builder->select(implode(',',$this->column_select));
         $this->builder->join('m_products','m_products.id = t_cashier_temp.product_id');
         $this->builder->join('m_units','m_units.id = m_products.unit_id','left');
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
         //     $this->builder->where($data);
     
         $query = $this->builder->get();
         return $query->getResult();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        // $this->builder->where($data);
        $this->builder->get();
        return $this->builder->countAll();
    }
 
    public function count_all()
    {
        // $this->builder->where($data);

        $this->builder->from($this->table);
        return $this->builder->countAll();
    }

    public function deleteAllcart(){
        $this->builder = $this->db->table($this->table);
    	return $this->builder->truncate();
    }
    public function getTotalCart(){
        $this->builder = $this->db->table($this->table);
        $this->builder->selectSum('subtotal');
        $query = $this->builder->get();
        return $query->getRow();
    }
    public function saveAllcart($request){
    	$CashiersModel = new CashiersModel();
    	$CashiersModel->db->transBegin();

    	try {
    		$getTotal = $this->getTotalCart();
	    	$data = array(
	            'invoice' 		=> date('YmdHis'),
	            'total'  		=> $getTotal->subtotal,
	            'pay'			=> $request->getPost("input_pay"),
	            'changes'		=> $request->getPost("input_pay") - $getTotal->subtotal,
	        );
			$CashiersModel->insert($data);


			$CashiersModel_id = $CashiersModel->getInsertID();
			$this->db->query('insert into t_cashier_detail (cashier_id,product_id,qty,price,subtotal) select '.$CashiersModel_id.',product_id,qty,price,subtotal from t_cashier_temp');

			$this->builder = $this->db->table($this->table);
    		$this->builder->truncate();

			$CashiersModel->db->transCommit();
			return  true;
		} catch (\Exception $e) {
			$CashiersModel->db->transRollback();
			return false;
		}
    	
    }
}