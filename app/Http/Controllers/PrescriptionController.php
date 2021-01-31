<?php

namespace App\Http\Controllers;

use App\Http\Services\PrescriptionService;
use App\Http\Services\SymtonService;

class PrescriptionController extends Controller
{
    protected $prescriptionService;
    protected $symtonService;

    public function __construct
    (
        PrescriptionService $prescriptionService,
        SymtonService $symtonService
    )
    {
        $this->prescriptionService = $prescriptionService;
        $this->symtonService = $symtonService;
    }

    public function index()
    {
        $prescriptions  = $this->prescriptionService->getAll();
        return view('formExamination.listExam', compact('prescriptions'));
    }

    public function create()
    {
       $symptons = $this->symtonService->getAll();
        return view('formExamination.formExam', compact('symptons'));
    }



}
