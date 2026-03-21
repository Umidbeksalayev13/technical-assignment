<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    public function store(Request $request){

        $this->checkDate();

        if($this->checkDate()){
          return  redirect()->back()->with('error','Your can create only 1 day application a day');
        }
        if($request->hasFile('file')){
            $name = $request->file('file')->getClientOriginalName();
           $path = $request->file('file')->storeAs(
               'files',
               $name,
               'public'
           );
        }
        $request->validate([
            'subject' => 'required |max:255',
            'message' => 'required',
            'file' => 'file|mimes:jpeg,png,jpg,pdf,gif,svg|max:2048'
        ]);
       $application = Application::create([
           'user_id'=>auth()->user()->id,
           'subject'=>$request->subject,
           'message'=>$request->message,
           'file_url'=>$path ?? null,
       ]);

       return redirect()->back();
    }

    protected function checkDate(){
        if(auth()->user()->applications()->latest()->first() == null){
            return false;
        }
        $last_application = auth()->user()->applications()->latest()->first();
        $last_app_date = Carbon::parse($last_application->created_at)->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');

        if($last_app_date == $today){
            return true;
        }
    }
}
