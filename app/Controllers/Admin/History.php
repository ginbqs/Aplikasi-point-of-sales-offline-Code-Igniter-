<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Services;

use \App\Models\CashiersModel;
use \App\Models\CashiersDetailModel;

class History extends BaseController
{
	public function index()
	{
		return view('admin/history/index');
	}
	public function json(){
        $request = \Config\Services::request();
        $CashiersModel = new CashiersModel();

		$list = $CashiersModel->get_datatables();
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            $row[] = $no;
            $row[] = $lists->invoice;
            $row[] = date('d M Y H:i:s',strtotime($lists->invoice));
            $row[] = number_format($lists->total,2);
            $row[] = number_format($lists->pay,2);
            $row[] = number_format($lists->changes,2);
            $row[] = number_format($lists->total - $lists->original_total,2);
            $row[] = "<a href=".site_url('admin/history/show/'.$lists->id)."><button class='btn btn-success'><i class='fa fa-eye'></i></button></a> <button class='btn btn-danger' onclick='deleteHistory(".$lists->id.")'><i class='fa fa-trash'></i></button>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $CashiersModel->count_all(),
            "recordsFiltered" => $CashiersModel->count_filtered(),
            "data" => $data,
        );
 
        return json_encode($output);
	}
    public function show($id){
        $request = \Config\Services::request();
        $CashiersModel = new CashiersModel();

        
        $cashier = $CashiersModel->getDetail($id);
        $data['dt_cashier'] = $cashier;
        return view('admin/history/detail',$data);
    }
    public function delete($id){
        $request = \Config\Services::request();
        $CashiersModel = new CashiersModel();

        $update = $CashiersModel->delete($id);
        echo json_encode(array("status" => TRUE,"message"=>"Data berhasil dihapus!"));
    }
    
    public function jsonDetail($id){
        $request = \Config\Services::request();
        $CashiersDetailModel = new CashiersDetailModel();

        $list = $CashiersDetailModel->get_datatables($id);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            $row[] = $no;
            $row[] = $lists->name;
            $row[] = $lists->qty;
            $row[] = number_format($lists->original_price,2);
            $row[] = number_format($lists->original_subtotal,2);
            $row[] = number_format($lists->price,2);
            $row[] = number_format($lists->subtotal,2);
            $row[] = number_format($lists->subtotal - $lists->original_subtotal,2);
            $data[] = $row;
        }
        // 
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $CashiersDetailModel->count_all($id),
            "recordsFiltered" => $CashiersDetailModel->count_filtered($id),
            "data" => $data,
        );
 
        return json_encode($output);
    }
}
