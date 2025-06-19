<?php

namespace App\Http\Controllers;
use App\Models\Testimoni;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Menampilkan semua barang di halaman utama
    public function index()
    {
        $tools = Item::all(); 
        $testimonis = Testimoni::latest()->take(3)->get();
        return view('index', compact('tools', 'testimonis'));
    }

    // Menampilkan form tambah barang
    public function create()
    {
        return view('items.create');
    }

    // Menyimpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('image')->store('items', 'public');

        Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => $path,
        ]);

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan!');
    }


}

?>