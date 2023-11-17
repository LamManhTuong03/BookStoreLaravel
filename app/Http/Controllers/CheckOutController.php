<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    //
    public function __construct()
    {
//    $this->middleware('auth');
    }

    public function checkout(Request $request)
    {
        $request->totalProductAmount = $request->totalProductAmount * 1000;
        session()->put('id_order', $request->id_order);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

        $vnp_TmnCode = "DL0EA7AJ"; //Website ID in VNPAY System
        $vnp_HashSecret = "GOGAQDDKQGSHOENQIKCHZBMXCIZBQVXJ"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('handlePayment') . "?msg=success";
//        $vnp_apiUrl = " https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
//Config input format
//Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = time(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh-toan-don-hang"; //mô tả đơn hàng
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $request->totalProductAmount * 100;
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_ExpireDate = $expire;

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

//var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);
        if ($request->totalProductAmount) {
            return redirect($vnp_Url);
        } else {
            echo json_encode($returnData);
        }
    }

    public function handlePayment(Request $request)
    {
        if ($request->vnp_ResponseCode == 00) {
            $order = Order::all();
            $user = auth()->user()->id;
            $user->order_id = session('id_order');
            $user->save();
            return view('frontend.checkout.index',compact('user','order'));
        } else {
            session()->forget('id_order');
            dd('Thanh toán koo thành công');
        }
    }
}
