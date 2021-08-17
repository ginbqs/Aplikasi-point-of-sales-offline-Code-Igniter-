<?php

namespace App\Controllers\Admin\Master_data;

use App\Controllers\BaseController;
use Config\Services;

use \App\Models\UnitsModel;

class Units extends BaseController
{
	public function index()
	{
        $UnitsModel = new UnitsModel();
        $units = $UnitsModel->getAll();

        $data=array();
        $data['dt_units'] = $units;

		return view('admin/master_data/units/index',$data);
	}
	public function json(){
        $request = \Config\Services::request();
        $UnitsModel = new UnitsModel();

		$list = $UnitsModel->get_datatables();
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            $row[] = $no;
            $row[] = $lists->name;
            $row[] = "<button class='btn btn-success' onclick='editUnits(".$lists->id.")'><i class='fa fa-edit'></i></button> <button class='btn btn-danger' onclick='deleteUnits(".$lists->id.")'><i class='fa fa-trash'></i></button>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $UnitsModel->count_all(),
            "recordsFiltered" => $UnitsModel->count_filtered(),
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
        ])) {
            echo json_encode(array("status" => FALSE,"message"=>$this->validator->getErrors()));
        } else {
            $UnitsModel = new UnitsModel();

            $data = array(
                'name'  => $request->getPost('input_name'),
            );
            $insert = $UnitsModel->insert($data);
            echo json_encode(array("status" => TRUE,"message"=>"Data berhasil ditambahkan!"));
        }
    }
    public function edit($id){
        $request = \Config\Services::request();
        $UnitsModel = new UnitsModel();

        
        $data = $UnitsModel->getDetail($id);
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
        ])) {
            echo json_encode(array("status" => FALSE,"message"=>$this->validator->getErrors()));
        } else {
            $UnitsModel = new UnitsModel();

            $data = array(
                'name'  => $request->getPost('input_name'),
            );

            $update = $UnitsModel->update($request->getPost('input_id'),$data);
            echo json_encode(array("status" => TRUE,"message"=>"Data berhasil ditambahkan!"));
        }
    }
    public function delete($id){
        $request = \Config\Services::request();
        $UnitsModel = new UnitsModel();

        $update = $UnitsModel->delete($id);
        $UnitsModel->purgeDeleted();
        echo json_encode(array("status" => TRUE,"message"=>"Data berhasil dihapus!"));
    }
    
}
