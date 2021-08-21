<?php

namespace App\Controllers\Admin\Master_data;

use App\Controllers\BaseController;
use Config\Services;

use \App\Models\ProductsModel;
use \App\Models\UnitsModel;

class Products extends BaseController
{
	public function index()
	{
        $UnitsModel = new UnitsModel();
        $units = $UnitsModel->getAll();

        $data=array();
        $data['dt_units'] = $units;

		return view('admin/master_data/products/index',$data);
	}
	public function json(){
        $request = \Config\Services::request();
        $ProductsModel = new ProductsModel();

		$list = $ProductsModel->get_datatables();
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            $row[] = $no;
            $row[] = $lists->name;
            $row[] = number_format($lists->original_price,2).' /'.$lists->m_units_name;
            $row[] = number_format($lists->price,2).' /'.$lists->m_units_name;
            $row[] = $lists->desc;
            $row[] = "<button class='btn btn-success' onclick='editProducts(".$lists->id.")'><i class='fa fa-edit'></i></button> <button class='btn btn-danger' onclick='deleteProducts(".$lists->id.")'><i class='fa fa-trash'></i></button>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $ProductsModel->count_all(),
            "recordsFiltered" => $ProductsModel->count_filtered(),
            "data" => $data,
        );
 
        return json_encode($output);
	}
    public function getUnits(){
        $request = \Config\Services::request();
        $UnitsModel = new UnitsModel();

        $output = $UnitsModel->getAll();
        return json_encode($output);
    }
    public function create(){
        $request = \Config\Services::request();
        if (!$this->validate([
            'input_name' => [
                'rules'     => 'required',
                "label"     => "Nama",
                'errors'    => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'input_price' => [
                'rules'     => 'required|numeric',
                "label"     => "Harga",
                'errors'    => [
                    'required' => '{field} Harus diisi',
                    'valid_email' => 'Format Email Harus Valid'
                ]
            ],
            'input_unit_id' => [
                'rules'     => 'required',
                "label"     => "Satuan",
                'errors'    => [
                    'required' => '{field} Harus diisi'
                ]
            ]
        ])) {
            echo json_encode(array("status" => FALSE,"message"=>$this->validator->getErrors()));
        } else {
            $ProductsModel = new ProductsModel();

            $data = array(
                'name'  => $request->getPost('input_name'),
                'original_price' => empty($request->getPost('input_original_price')) ? 0 : $request->getPost('input_original_price'),
                'price' => $request->getPost('input_price'),
                'desc'  => $request->getPost('input_desc'),
                'unit_id'=> $request->getPost('input_unit_id'),
            );
            $insert = $ProductsModel->insert($data);
            echo json_encode(array("status" => TRUE,"message"=>"Data berhasil ditambahkan!"));
        }
    }
    public function edit($id){
        $request = \Config\Services::request();
        $ProductsModel = new ProductsModel();

        
        $data = $ProductsModel->getDetail($id);
        echo json_encode(array("status" => TRUE,"message"=>$data));
    }
    public function update(){
        $request = \Config\Services::request();
        if (!$this->validate([
            'input_id' => [
                'rules'     => 'required',
                "label"     => "ID",
                'errors'    => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'input_name' => [
                'rules'     => 'required',
                "label"     => "Nama",
                'errors'    => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'input_price' => [
                'rules'     => 'required|numeric',
                "label"     => "Harga",
                'errors'    => [
                    'required' => '{field} Harus diisi',
                    'valid_email' => 'Format Email Harus Valid'
                ]
            ],
            'input_unit_id' => [
                'rules'     => 'required',
                "label"     => "Satuan",
                'errors'    => [
                    'required' => '{field} Harus diisi'
                ]
            ]
        ])) {
            echo json_encode(array("status" => FALSE,"message"=>$this->validator->getErrors()));
        } else {
            $ProductsModel = new ProductsModel();

            $data = array(
                'name'  => $request->getPost('input_name'),
                'original_price' => empty($request->getPost('input_original_price')) ? 0 : $request->getPost('input_original_price'),
                'price' => $request->getPost('input_price'),
                'desc'  => $request->getPost('input_desc'),
                'unit_id'=> $request->getPost('input_unit_id'),
            );

            $update = $ProductsModel->update($request->getPost('input_id'),$data);
            echo json_encode(array("status" => TRUE,"message"=>"Data berhasil ditambahkan!"));
        }
    }
    public function delete($id){
        $request = \Config\Services::request();
        $ProductsModel = new ProductsModel();

        $update = $ProductsModel->delete($id);
        $ProductsModel->purgeDeleted();
        echo json_encode(array("status" => TRUE,"message"=>"Data berhasil dihapus!"));
    }
    
}
