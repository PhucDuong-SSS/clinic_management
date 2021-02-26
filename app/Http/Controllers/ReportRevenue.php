<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\Prescription;
use Faker\Provider\Medical;
use Illuminate\Support\Facades\DB;

class ReportRevenue extends Controller
{

    public function show()
    {
       return view('report.showReport');
    }

    public function dateReport(Request $request)
    {
        $dateRenueveExamPrice = 0;
        $dateRenueveMedicine= 0;
        $totalDateReneuve = 0;
        $medicineProfit=0;
        $totalProfit =0;
        $day = $request->day;
        $month = $request->month;
        $year = $request->year;
        $prescriptions = [];
        if(isset($day) && isset($month) && isset($year))
        {
            $date = $year.'-'.$month.'-'.$day;
            $prescriptions  = Prescription::where('created_at','like','%'.$date.'%')->get();

        }
        if(isset($month) && isset($year) && !isset($day))
        {
            $prescriptions  = Prescription::whereMonth('created_at','=',$month)->whereYear('created_at','=',$year)->get();


        }
        if(isset($year) && !isset($month) && !isset($day))
        {
            $prescriptions  = Prescription::whereYear('created_at','=',$year)->get();

        }

        if(count($prescriptions))
        {
            foreach($prescriptions as $prescription)
            {
                $dateRenueveExamPrice += (int)$prescription->exam_price;
                $id_prescription = $prescription->id;
                $prescription_medicine = DB::table('prescription_medicine')->where('id_prescrition',$id_prescription)->get();

                $dateRenueveMedicine = $this->getMedicineRenueve($prescription_medicine);
                $medicineOriginal  = $this->getMedicineOrginalPrice($prescription_medicine);

                $medicineProfit += ($dateRenueveMedicine - $medicineOriginal);





            }
            $totalProfit = $dateRenueveExamPrice + $medicineProfit;
            $totalDateReneuve = $dateRenueveExamPrice+$dateRenueveMedicine;
            $html = view('report.htmlReport',compact('dateRenueveExamPrice','dateRenueveMedicine','totalDateReneuve','medicineProfit','totalProfit'))->render();
            return response()->json(['html'=>$html, 'date'=>$prescriptions]);
        }
        return response()->json(['html'=>"<div><h3 style='text-align:center;'>Khong tim thay du lieu</h3></div>",'year'=>$prescriptions]);



    }





     public function getMedicineRenueve($prescription_medicine)
    {
        $renueveMedicine = 0;
        foreach($prescription_medicine as $medicine)
        {
            $renueveMedicine += (int)$medicine->sell_price;
        }
        return $renueveMedicine;
    }

    public function getMedicineOrginalPrice($prescription_medicine)
    {
        $medicineOriginal = 0;
        $amount= 0 ;
        foreach($prescription_medicine as $medicine)
        {
            $id_medicine = $medicine->id_medicine;
            $amount = $medicine->amount;

            $unit_price = DB::table('lots')->where('id_med',$id_medicine)->value('unit_price');


            $medicineOriginal += $amount*$unit_price;
        }
        return $medicineOriginal;
    }
}
