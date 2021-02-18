<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
   public function getSellPrice(Request $request)
   {
       $id = $request->medicine_id;
       $medicine = Medicine::findOrFail($id);

       $morning =(int)$request->morning;
       $midday = (int)$request->midday;
       $afternoon = (int)$request->afternoon;
       $evening = (int)$request->evening;
       $sell_price = (int)$medicine->sell_price;
       $number_of_day = (int)$request->number_of_day;
       $calc_price = ($morning + $midday + $afternoon + $evening)*$sell_price*$number_of_day;


       $success = 'Thành công';
       return response()->json(['calc_price'=>$calc_price,'success'=>$success],200);


   }

}
