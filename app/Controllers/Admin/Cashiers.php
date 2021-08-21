<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Services;

use \App\Models\ProductsModel;
use \App\Models\CashiersTempModel;

class Cashiers extends BaseController
{
	public function index()
	{
		return view('admin/cashiers/index');
	}
    
    public function jsonProduct(){
        $request = \Config\Services::request();
        $ProductsModel = new ProductsModel();

        $list = $ProductsModel->get_datatables();
        $data = array();
        foreach ($list as $lists) {
            $row    = array();
            $row[] = $lists->name.'<br /><span style="font-size:14px;font-weight:bold">'.$lists->desc.'</span>';
            $row[] = number_format($lists->price,2).' /'.$lists->m_units_name.'<br /><span style="font-size:14px;font-weight:bold">'.number_format($lists->original_price,2).'</span>';;
            $row[] = "<div class='row'>
	            			<div class='col-md-6'>
	            				<button class='btn btn-block btn-warning' onclick='cartProducts(".$lists->id.")'><i class='fa fa-edit'></i></button>
	            			</div>
	            			<div class='col-md-6'>
	            				<button class='btn btn-block btn-success' onclick='save(".$lists->id.")'><i class='fa fa-plus'></i></button>
	            			</div>
            			</div>";
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
    public function getProduct($id){
        $request = \Config\Services::request();
        $ProductsModel = new ProductsModel();

        
        $data = $ProductsModel->getDetail($id);
        echo json_encode(array("status" => TRUE,"message"=>$data));
    }
    
    public function addCart(){
        $request = \Config\Services::request();
        if (!$this->validate([
            'input_id' => [
                'rules'     => 'required',
                "label"     => "ID",
                'errors'    => [
                    'required' => '{field} Harus diisi'
                ]
            ]
        ])) {
            echo json_encode(array("status" => FALSE,"message"=>$this->validator->getErrors()));
        } else {
            $CashiersTempModel = new CashiersTempModel();
            $ProductsModel = new ProductsModel();

            $getProduct = $ProductsModel->getDetail($request->getPost('input_id'));
            $getCashierTemp = $CashiersTempModel->getDetail($request->getPost('input_id'));

            if(!isset($getProduct->price)){
            	echo json_encode(array("status" => FALSE,"message"=>"Data tidak ditambahkan!"));
            }

            if(isset($getCashierTemp)){
            	$qty = (isset($getCashierTemp->qty) ? $getCashierTemp->qty : 0) + $request->getPost('input_qty');
				$data = array(
	                'qty' 			=> $qty,
                    'original_price' => $getProduct->original_price,
                    'price'         => $getProduct->price,
                    'original_subtotal'      => $qty*$getProduct->original_price,
	                'subtotal'		=> $qty*$getProduct->price,
	            );
				$insert = $CashiersTempModel->update($getCashierTemp->id,$data);
            }else{
            	$data = array(
	                'product_id'  	=> $request->getPost('input_id'),
	                'qty' 			=> $request->getPost('input_qty'),
                    'original_price'=> $getProduct->original_price,
	                'price'  		=> $getProduct->price,
                    'original_subtotal'    => $request->getPost('input_qty')*$getProduct->original_price,
	                'subtotal'		=> $request->getPost('input_qty')*$getProduct->price,
	            );
				$insert = $CashiersTempModel->insert($data);
            
            }
            echo json_encode(array("status" => TRUE,"message"=>"Data berhasil ditambahkan!"));
        }
    }
    public function jsonCashiersTemp(){
        $request = \Config\Services::request();
        $CashiersTempModel = new CashiersTempModel();

        $list = $CashiersTempModel->get_datatables();
        $data = array();
        foreach ($list as $lists) {
            $row    = array();
            $row[] = '<span style="font-weight:bold">'.$lists->qty.'</span>'.'&nbsp;&nbsp;&nbsp;'.$lists->name.'<br /><span style="font-size:14px;font-weight:bold">Rp. '.number_format($lists->price,2).' /'.$lists->m_units_name.'</span>';
            $row[] = number_format($lists->subtotal,2);
            $row[] = "<button class='btn btn-block btn-danger' onclick='DeletecartProducts(".$lists->id.")'><i class='fa fa-trash'></i></button>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $CashiersTempModel->count_all(),
            "recordsFiltered" => $CashiersTempModel->count_filtered(),
            "data" => $data,
        );
 
        return json_encode($output);
    }
    public function deleteCart($id){
        $request = \Config\Services::request();
        $CashiersTempModel = new CashiersTempModel();

        $delete = $CashiersTempModel->delete($id);
        $CashiersTempModel->purgeDeleted();
        echo json_encode(array("status" => TRUE,"message"=>"Data berhasil dihapus!"));
    }
    public function deleteAllcart(){
    	$request = \Config\Services::request();
        $CashiersTempModel = new CashiersTempModel();

        $delete = $CashiersTempModel->deleteAllcart();
    	echo json_encode(array("status" => TRUE,"message"=>"Data berhasil dihapus!"));	
    }
    public function getTotalCart(){
        $request = \Config\Services::request();
        $CashiersTempModel = new CashiersTempModel();

        
        $data = $CashiersTempModel->getTotalCart();
        $data = $data->subtotal;
        echo json_encode(array("status" => TRUE,"message"=>$data));
    }
    public function saveAllcart(){
    	$request = \Config\Services::request();
        $CashiersTempModel = new CashiersTempModel();

        
        $data = $CashiersTempModel->saveAllcart($request);
        echo json_encode(array("status" => TRUE,"message"=>'Data berhasil disimpan & diselesaikan!'));
    }
}
