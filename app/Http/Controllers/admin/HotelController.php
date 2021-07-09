<?php

namespace App\Http\Controllers\admin;

use App\Hotel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest;
use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HotelController extends Controller
{
    public function viewRate()
    {
        $hotels=Hotel::pluck("hotel_name","hotel_id");
        $rates=Rate::select("rates.*","hotels.hotel_name")->join("hotels","hotels.hotel_id","=","rates.hotel_id")->get();
        $route_name=route("rates.store");
        return view("admin.rate",compact("hotels",$hotels,"rates",$rates))->with("route_name",$route_name);
    }

    public function storeRate(RateRequest $request)
    {
        $from_date= date("Y-m-d",strtotime($request->from_date));
        $to_date= date("Y-m-d",strtotime($request->to_date));

        $rate=Rate::where("hotel_id","=",$request->hotel_id)->where(function ($query) use ($from_date, $to_date) {
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
            });
        })->get();

        if(count($rate)>0)
        {
            $noti=array('message'=>"Rate is Already Set for these dates",'alert-type'=>"error");
            return redirect()->route("rates.view")->with($noti);
        }
        else{
            $rate=new Rate(array(
                "hotel_id"      =>$request->hotel_id,
                "from_date"     =>date("Y-m-d",strtotime($request->from_date)),
                "to_date"       =>date("Y-m-d",strtotime($request->to_date)),
                "rate_for_adult"    =>$request->rate_for_adult,
                "rate_for_child"    =>$request->rate_for_child,
            ));
            $rate->save();
            $noti=array('message'=>"Rate Save Successfully",'alert-type'=>"success");
            return redirect()->route("rates.view")->with($noti);
        }
    }

    public function editRate($rate_id)
    {
        $hotels=Hotel::pluck("hotel_name","hotel_id");
        $rates=Rate::select("rates.*","hotels.hotel_name")->join("hotels","hotels.hotel_id","=","rates.hotel_id")->get();
        $route_name=route("rates.update");
        $rate=Rate::where("rate_id","=",$rate_id)->first();
        return view("admin.rate",compact("hotels",$hotels,"rates",$rates,"rate",$rate))->with("route_name",$route_name);
    }

    public function updateRate(Request $request)
    {
        $from_date= date("Y-m-d",strtotime($request->from_date));
        $to_date= date("Y-m-d",strtotime($request->to_date));

        $rates=Rate::where(function ($query) use ($from_date, $to_date) {
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
            });
        })->get();

        if(count($rates)>1)
        {
            $noti=array('message'=>"Rate is Already Set for these dates",'alert-type'=>"error");
            return redirect()->route("rates.view")->with($noti);
        }
        else{
            $flag=0;
            foreach($rates as $rate)
            {
                if($rate->rate_id==$request->rate_id)
                {
                    $flag=1;
                }
            }
            if($flag==1)
            {
                $rate=Rate::where("rate_id","=",$request->rate_id)->first();
                $rate->hotel_id=$request->hotel_id;
                $rate->from_date=date("Y-m-d",strtotime($request->from_date));
                $rate->to_date=date("Y-m-d",strtotime($request->to_date));
                $rate->rate_for_adult=$request->rate_for_adult;
                $rate->rate_for_child=$request->rate_for_child;
                $rate->save();
                $noti=array('message'=>"Rate Successfully Updated",'alert-type'=>"success");
                return redirect()->route("rates.view")->with($noti);
            }else{
                $noti=array('message'=>"Rate is Already Set for these dates",'alert-type'=>"error");
                return redirect()->route("rates.view")->with($noti);
            }
        }
    }

    public function deleteRate(Request $request)
    {
        Rate::where("rate_id","=",$request->id)->delete();
        $noti=array('message'=>"Rate Successfully Deleted",'alert-type'=>"success");
        return redirect()->route("rates.view")->with($noti);
    }
}
