<?php

namespace App\Models;

use CodeIgniter\Model;


class ProductsModel extends Model
{
   
    protected $table      = 'm_products';
    protected $primaryKey = 'id';

    // protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'price','desc','unit_id'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation  = false;

    protected $column_order = [NULL,'m_products.name','m_units.name','m_products.price','m_products.desc'] ;
    protected $column_select = ['m_products.id','m_products.name','m_units.name as m_units_name','m_products.price','m_products.desc'];
    protected $column_search = ['m_products.id','m_products.name','m_units.name','m_products.price','m_products.desc'];
    protected $order = ['m_products.name' => 'ASC'];

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
         $this->builder->where('m_products.deleted_at',NULL);
         $this->builder->select(implode(',',$this->column_select));
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

    public function getDetail($id)
    {
        $this->builder = $this->db->table($this->table);
        $this->builder->where('m_products.id',$id);
        $this->builder->select('m_products.*,m_units.name as m_units_name');
        $this->builder->join('m_units', 'm_units.id = m_products.unit_id');
        $query = $this->builder->get();
        return $query->getRow();
    }
}