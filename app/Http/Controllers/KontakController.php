<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function kirim(Request $request)
    {
        // Contoh validasi sederhana
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
