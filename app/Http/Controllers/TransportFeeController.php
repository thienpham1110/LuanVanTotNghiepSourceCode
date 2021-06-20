<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\TransportFee;
use Illuminate\Support\Facades\Redirect;

class TransportFeeController extends Controller
{
    public function TransportFee(Request $request){
        $city=City::orderby('id','ASC')->get();
        return view('admin.pages.transportfee.transport_fee')
        ->with(compact('city'));
    }

    public function SelectTransportFee(Request $request){
        $data =$request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province=Province::where('tinhthanhpho_id',$data['ma_id'])->orderby('id','ASC')->get();
                $output.='<option>Choose Province</option>';
                foreach($select_province as $key =>$province){
                    $output.='<option value="'.$province->id.'">'.$province->quanhuyen_name.'</option>';
                }
            }else{
    			$select_wards = Wards::where('quanhuyen_id',$data['ma_id'])->orderby('id','ASC')->get();
    			$output.='<option>Choose Wards</option>';
    			foreach($select_wards as $k => $ward){
    				$output.='<option value="'.$ward->id.'">'.$ward->xaphuongthitran_name.'</option>';
    			}
    		}
            echo $output;
        }
    }
    public function TransportFeeAdd(Request $request){
        $data =$request->all();
        $transport_fee_old=TransportFee::orderby('id','DESC')->get();
        foreach($transport_fee_old as $key =>$value){
            if($value->xaphuong_id==$data['wards']&& $value->quanhuyen_id==$data['province']&& $value->tinhthanhpho_id==$data['city']){
                return Redirect::to('/transport-fee');
            }else{
                $transport_fee=new TransportFee();
                $transport_fee->tinhthanhpho_id=$data['city'];
                $transport_fee->quanhuyen_id=$data['province'];
                $transport_fee->xaphuong_id=$data['wards'];
                $transport_fee->phivanchuyen_phi_van_chuyen=$data['transport_fee'];
                $transport_fee->phivanchuyen_ngay_giao_hang_du_kien=$data['transport_fee_day'];
                $transport_fee->save();
            }
        }
    }
    public function SelectFee(){
        $fee=TransportFee::orderby('id','DESC')->get();
        $output = '';
        $output .=
         '<div class="card-box">
            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100"  id="scroll-vertical-datatable">
                <thead class="bg-light">
                <tr>
                    <th class="font-weight-medium">City</th>
                    <th class="font-weight-medium">Province</th>
                    <th class="font-weight-medium">Wards</th>
                    <th class="font-weight-medium">Fee</th>
                    <th class="font-weight-medium">Fee Day</th>
                </tr>
                </thead>
                <tbody class="font-14">';
                    foreach ($fee as $key=>$value){
                        $output .=
                        '<tr>
                            <td>'. $value->City->tinhthanhpho_name .'</td>
                            <td>'. $value->Province->quanhuyen_name .'</td>
                            <td>'. $value->Wards->xaphuongthitran_name .'</td>
                            <td contenteditable data-feeship_id="'.$value->id.'" class="fee-edit">'.number_format( $value->phivanchuyen_phi_van_chuyen,0,',','.', ).'</td>
                            <td contenteditable data-feeship_id="'.$value->id.'" class="fee-edit-day">'. $value->phivanchuyen_ngay_giao_hang_du_kien .'</td>
                        </tr>';
                    }
                    $output .='
                </tbody>
            </table>
        </div>';
        echo $output;
    }

    public function TransportFeeUpdate(Request $request){
        $data =$request->all();
        $transport_fee= TransportFee::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'],'.');
        $transport_fee->phivanchuyen_phi_van_chuyen=$fee_value;
        $transport_fee->save();
        Session::put('message','Update Success');
    }
    public function TransportFeeUpdateDay(Request $request){
        $data =$request->all();
        $transport_fee= TransportFee::find($data['feeship_id']);
        $transport_fee->phivanchuyen_ngay_giao_hang_du_kien=$data['fee_value'];
        $transport_fee->save();
        Session::put('message','Update Success');
    }
}
