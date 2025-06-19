<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $tools = Tool::all();
        $testimonis = Testimoni::all();
        return view('index', compact('tools', 'testimonis'));
    }
}
