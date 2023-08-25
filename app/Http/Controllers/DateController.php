<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; 

use Illuminate\Http\Request;

class DateController extends Controller
{
    /**
     * 
     * 一覧表示
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $dates = $user->dates()->orderBy('id','DESC')->get();
    
        return view('food-records.index', compact('dates'));
    }
}
