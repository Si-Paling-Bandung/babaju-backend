<?php

namespace App\Http\Controllers;

use App\Models\Topics;
use App\User;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $kader = User::where('role','=','kader')->count();
        $tenaga_kehesatan = User::where('role','=','tenaga_kesehatan')->count();
        $perangkat_daerah = User::where('role','=','perangkat_daerah')->count();
        $courses = Product::all()->count();

        $widget = [
            'kader' => $kader,
            'tenaga_kehesatan' => $tenaga_kehesatan,
            'perangkat_daerah' => $perangkat_daerah,
            'courses' => $courses,
        ];

        return view('home', compact('widget'));
    }
}
