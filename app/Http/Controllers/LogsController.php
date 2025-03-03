<?php

namespace App\Http\Controllers;
use App\Models\Logs;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    //


    public function logs(Request $request){
        return Logs::orderBy('created_at', 'desc')->get();
    }
}
