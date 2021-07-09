<?php

namespace App\Http\Controllers\front;

use App\Hotel;
use App\Http\Controllers\Controller;
use App\Rate;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function bookingView()
    {
        $hotels=Hotel::pluck("hotel_name","hotel_id");
        return view("front.booking",compact("hotels",$hotels));
    }

    public function checkAmount(Request $request)
    {
        $from_date= date("Y-m-d",strtotime($request->from_date));
        $to_date= date("Y-m-d",strtotime($request->to_date));
        $rates=Rate::where("hotel_id","=",$request->hotel_id)->where(function ($query) use ($from_date, $to_date) {
            $query->where(function ($q) use ($from_date, $to_date) {
                $q->where('from_date', '>=', $from_date)
                    ->where('from_date', '<', $to_date);
            })->orWhere(function ($q) use ($from_date, $to_date) {
                $q->where('from_date', '<=', $from_date)
                    ->where('to_date', '>', $to_date);
            })->orWhere(function ($q) use ($from_date, $to_date) {
                $q->where('to_date', '>', $from_date)
                    ->where('to_date', '<=', $to_date);
            })->orWhere(function ($q) use ($from_date, $to_date) {
                $q->where('from_date', '>=', $from_date)
                    ->where('to_date', '<=', $to_date);
            })->orWhere(function ($q) use ($from_date, $to_date) {
                $q->where('from_date', '=', $to_date);
            })->orWhere(function ($q) use ($from_date, $to_date) {
                $q->where('to_date', '=', $from_date);
            });
        })->get();
        $response=array();
        if(count($rates)>0)
        {
            $response["success"]=1;
            $diff=strtotime($to_date) - strtotime($from_date);
            $days=ceil($diff/84000);

            $per_adult=0;
            $per_child=0;
            $cur_date=$from_date;
            for($i=0;$i<$days;$i++)
            {
                $cur_date=date("Y-m-d",strtotime($from_date.' +'.$i.' day'));
                foreach($rates as $rate)
                {
                    if($cur_date>=$rate->from_date && $cur_date<=$rate->to_date)
                    {
                        $per_adult+=($rate->rate_for_adult*$request->no_of_adult);
                        $per_child+=($rate->rate_for_child*$request->no_of_child);
                    }
                }
            }

            $response["per_adult"]=$per_adult;
            $response["per_child"]=$per_child;
            $response["total"]=$response["per_adult"]+$response["per_child"];
            $response["no_of_days"]=$days;
        }
        else{
            $response["success"]=0;;
        }
        return response()->json($response);
    }
}
