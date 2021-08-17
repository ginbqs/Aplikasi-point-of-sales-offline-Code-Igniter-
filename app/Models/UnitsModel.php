<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitsModel extends Model
{
    protected $table      = 'm_units';
    protected $primaryKey = 'id';

    // protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $useAutoIncrement = true;
    protected $allowedFields = ['name'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation  = false;

    protected $column_order = [NULL,'m_units.name'] ;
    protected $column_select = ['m_units.id','m_units.name'];
    protected $column_search = ['m_units.id','m_units.name'];
    protected $order = ['m_units.name' => 'ASC'];

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
         $this->builder->where('m_units.deleted_at',NULL);
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
        $this->builder->where('id',$id);
        $query = $this->builder->get();
        return $query->getRow();
    }


    public function getAll()
    {
        $this->builder = $this->db->table($this->table);
        $query = $this->builder->get();
        return $query->getResult();
    }

}