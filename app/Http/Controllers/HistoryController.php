<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    function index()
    {
        $history = Lot::all();
        return view('history.list', compact('medicines', 'med_categories', 'category'));
    }
}
