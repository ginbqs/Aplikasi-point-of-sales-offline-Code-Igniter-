<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Services;

use \App\Models\ProductsModel;
use \App\Models\UnitsModel;
use \App\Models\CashiersTempModel;
use \App\Models\CashiersModel;

class Dashboard extends BaseController
{
	public function index()
	{
		return view('admin/cashiers/index');
	}
    public function getTotalDashboard(){
        $request = \Config\Services::request();
        $ProductsModel  = new ProductsModel();
        $UnitsModel     = new UnitsModel();
        $CashiersModel          = new CashiersModel();
        $CashiersTempModel      = new CashiersTempModel();

        $getTotalProducts   =  $ProductsModel->getTotalProducts();
        $getTotalUnits      =  $UnitsModel->getTotalUnits();
        $getTotalCashiers       =  $CashiersModel->getTotalCashiers();
        $getTotalCashiersTemp   =  $CashiersTempModel->getTotalCart();


        $data = [
            'totalProducts'     => isset($getTotalProducts->total) ? $getTotalProducts->total : 0,
            'totalUnits'        => isset($getTotalUnits->total) ? $getTotalUnits->total : 0,
            'totalCashiers'     => isset($getTotalCashiers->subtotal) ? 'Rp. '.number_format($getTotalCashiers->subtotal,2) : 0,
            'totalCashiersTemp' => isset($getTotalCashiersTemp->subtotal) ? 'Rp. '.number_format($getTotalCashiersTemp->subtotal,2) : 0,
        ];
        echo json_encode(array("status" => TRUE,"message"=>$data));
    }
    public function getChart(){
        $CashiersModel = new CashiersModel();
        $getChart      = $CashiersModel->getChart();
        $data = array();
        foreach($getChart as $key){
            $data[$key->bulan] = $key->total;
        }
        $tanggal = [];
        $nilai = [];
        for($i=1;$i<=date("t", strtotime(date("Y-m-d")));$i++){
            $tanggal[] = $i;
            $nilai[] = isset($data[date("Y").sprintf('%02d', $i)]) ? $data[date("Y").sprintf('%02d', $i)] : 0;
        }
        $data = [
            'tanggal'   => $tanggal,
            'nilai'     => $nilai,
        ];
        echo json_encode(array("status" => TRUE,"message"=>$data));
    }

}
