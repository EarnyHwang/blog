<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(Route::has('login') && Auth::user())
		{
			return $this->browser(Auth::user()->name);
		}
		else
		{
			return view('bloghome');
		}
    }
	
	// 有PO文的首頁
	public function browser($authorAddress)
	{
		$articleData = DB::table($authorAddress)->select('id','title','article','created_at')->orderBy('id','desc')->get();
        return view('bloghome', ['articleData' => $articleData , 'authorAddress' => $authorAddress]);
	}
}
