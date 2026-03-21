<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main(){
        return redirect('dashboard');
    }
    public function dashboard()
    {
//        $last_application = auth()->user()->applications()->latest()->first();
//        $last_app_date = Carbon::parse($last_application->created_at)->format('Y-m-d');
//        $today = Carbon::now()->format('Y-m-d');
        return view('dashboard')->with([
            'applications'=>Application::latest()->paginate(4),
        ]);
    }
}
