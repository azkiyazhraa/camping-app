<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonis = Testimoni::latest()->take(3)->get();
        return view('index', compact('testimonis'));
    }

    public function create()
    {
        return view('testimoni.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:500',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if (Testimoni::count() >= 3) {
            return redirect()->back()->with('error', 'Testimoni sudah mencapai batas maksimum (3).');
        }

        $data = $request->only(['name', 'message']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimoni', 'public');
        }

        Testimoni::create($data);

        return redirect()->route('home')->with('success', 'Testimoni berhasil ditambahkan!');
    }
}