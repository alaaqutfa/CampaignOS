<?php
namespace App\Http\Controllers;

use App\Models\Plan;

class LandingController extends Controller
{
    public function index()
    {
        $plans = Plan::where('is_active','1')->get();
        return view('landing', compact('plans'));
    }
}
