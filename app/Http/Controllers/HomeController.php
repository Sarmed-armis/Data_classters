<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classter;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        /*
         *
        for($x=1;$x<=11;$x++){
            for($y=1;$y<=14;$y++){
                Classter::create([
                    'x_axis'=>$x,
                    'y_axis'=>$y,
                    'comment'=>'unvisited'
                ]);
            }

        }
        */
        $unvisiteds=Classter::where('comment','=','unvisited')->get();


        $visiteds=Classter::where('comment','=','visited')->get();

        return view('home',compact('unvisiteds','visiteds'));
    }
}
