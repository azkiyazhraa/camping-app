<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowers = Borrowing::paginate(10);
        return view('borrowers.index', compact('borrowers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tool_id' => 'required|array',
            'qty' => 'required|array',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
        ]);

        $borrowDate = Carbon::parse($request->borrow_date);
        $returnDate = Carbon::parse($request->return_date);
        $duration = $borrowDate->diffInDays($returnDate);
        $invoice = 'INV/CA/' . date('Ymd') . '/' . rand(1000, 9999);

        // Hitung total harga dari semua alat (kalau ada harga per alat)
        $totalPrice = 0;

        // Simpan data utama ke tabel borrowings
        $borrowing = Borrowing::create([
            'invoice' => $invoice,
            'user_id' => Auth::id(),
            'borrow_date' => $borrowDate,
            'return_date' => $returnDate,
            'long_time_borrowing' => $duration,
            'status' => 'pending',
            'total_price' => 0, // sementara 0, nanti diupdate
        ]);

        foreach ($request->tool_id as $index => $toolId) {
            $qty = $request->qty[$index];

            // Simpan detailnya
            BorrowingDetail::create([
                'borrowing_id' => $borrowing->id,
                'tool_id' => $toolId,
                'qty' => $qty,
            ]);

            // Kurangi stok alat
            Tool::where('id', $toolId)->decrement('stock', $qty);

            // Jika alat punya harga, bisa dihitung total
            $tool = Tool::find($toolId);
            if ($tool && $tool->rental_price) {
                $totalPrice += $tool->rental_price * $qty * $duration;
            }
        }

        // Update total price setelah semua dihitung
        $borrowing->update(['total_price' => $totalPrice]);

        return redirect()->back()->with('success', 'Peminjaman berhasil dikirim.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        //
    }

    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        if ($borrowing->status === 'pending') {
            $borrowing->update(['status' => 'borrowed']);
        }

        return redirect()->back()->with('success', 'Peminjaman disetujui.');
    }

    public function markReturned($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        if ($borrowing->status === 'borrowed') {
            // Kembalikan stok
            foreach ($borrowing->details as $detail) {
                Tool::where('id', $detail->tool_id)->increment('stock', $detail->qty);
            }

            $borrowing->update(['status' => 'returned']);
        }

        return redirect()->back()->with('success', 'Barang berhasil dikembalikan.');
    }
}
