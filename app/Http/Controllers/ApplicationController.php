<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    public function store(Request $request){
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
}
