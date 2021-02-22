<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrescriptionMedicineRequest;
use App\Models\Medicine;
use App\PrescriptionMedicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PrescriptionMedicineController extends Controller
{
    public function addPrescriptionMedicine(PrescriptionMedicineRequest $request)
    {
        $id = $request->medicine_id;
        $morning = $request->midday;

        $medicine = Medicine::findorFail($id);
        $oldPrescriptionMedicine = session('PrescriptionMedicine');

        $prescriptionMedicine = new PrescriptionMedicine($oldPrescriptionMedicine);
        $prescriptionMedicine->add($medicine,$request);
        session()->put('PrescriptionMedicine',$prescriptionMedicine);
        return $this->showPrescriptionMedicine('Thêm');



    }

    public function showPrescriptionMedicine($message)
    {
        $newPrescriptionMedicine = session('PrescriptionMedicine');
        $html = view('formExamination.medicine',compact('newPrescriptionMedicine'))->render();
        $success = $message."thành công";
        $amount = session('PrescriptionMedicine')->amount;
        return response()->json(['PrescriptionMedicine'=>$html,'qty'=>$amount,'success'=>$success]);
    }

    public function delete($id)
    {

        $product = Medicine::findOrFail($id);
        $oldPrescriptionMedicine = session('PrescriptionMedicine');
        $prescriptionMedicine = new PrescriptionMedicine($oldPrescriptionMedicine);

        $prescriptionMedicine->delete($id);
        session()->put('PrescriptionMedicine',$prescriptionMedicine);

        if(count($prescriptionMedicine->items) >= 0){
            return $this->showPrescriptionMedicine('Xoa');
        }
    }



}
