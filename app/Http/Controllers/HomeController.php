<?php

namespace App\Http\Controllers;
use Phpml\Clustering\DBSCAN;


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

        $datasets=Classter::select('x_axis','y_axis')->get();
        //$datasets=Classter::where('comment','=','unvisited')->select('x_axis','y_axis')->get();


        $samples2=[];
        foreach ($datasets as $dataset ){


            array_push($samples2,array($dataset->x_axis,$dataset->y_axis));
        }






        $dbscan = new DBSCAN($epsilon = 2, $minSamples =3);
        $ss=$dbscan->cluster($samples2);



        foreach ($ss[0] as $s){
            Classter::where('x_axis','=',$s[1])->where('y_axis','=',$s[0])->update(['comment'=>'visited']);
        }



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




    public function reset(){



        $datasets=Classter::select('x_axis','y_axis')->get();
        //$datasets=Classter::where('comment','=','unvisited')->select('x_axis','y_axis')->get();


        $samples2=[];
        foreach ($datasets as $dataset ){


            array_push($samples2,array($dataset->x_axis,$dataset->y_axis));
        }






        $dbscan = new DBSCAN($epsilon = 2, $minSamples =3);
        $ss=$dbscan->cluster($samples2);



        foreach ($ss[0] as $s){
            Classter::where('x_axis','=',$s[0])->where('y_axis','=',$s[1])->update(['comment'=>'unvisited']);
        }




        $unvisiteds=Classter::where('comment','=','unvisited')->get();


        $visiteds=Classter::where('comment','=','visited')->get();


        return view('home',compact('unvisiteds','visiteds'));







    }


    public function store (Request $request){



        $request->validate([
            'ex' => 'required|numeric|between:0,999999999.99',
            'min' => 'required|numeric|between:0,999999999.99'

        ]);



       // $datasets=Classter::select('x_axis','y_axis')->get();
        $datasets=Classter::where('comment','=','unvisited')->select('x_axis','y_axis')->get();


        $samples2=[];
        foreach ($datasets as $dataset ){


            array_push($samples2,array($dataset->x_axis,$dataset->y_axis));
        }




        $dbscan = new DBSCAN($epsilon = $request->ex, $minSamples =$request->min);
        $ss=$dbscan->cluster($samples2);



        foreach ($ss[0] as $s){
            Classter::where('x_axis','=',$s[1])->where('y_axis','=',$s[0])->update(['comment'=>'visited']);
        }




        return redirect('home');



    }





}
