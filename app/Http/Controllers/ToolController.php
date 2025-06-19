<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tools = Tool::paginate(10);
        return view('tools.index', compact('tools'));
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

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'stock' => 'required',
            'rental_price' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ]);

        if ($validate->fails()) {
            return redirect()->route('tools.index')->with('error', 'Tool created failed.' . $validate->errors()->first());
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Tool::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'rental_price' => $request->rental_price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('tools.index')->with('success', 'Tool created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tool $tool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tool $tool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tool $tool)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'stock' => 'required',
            'rental_price' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ]);

        if ($validate->fails()) {
            return redirect()->route('tools.index')->with('error', 'Tool updated failed.' . $validate->errors()->first());
        }

        if ($request->hasFile('image')) {
            if ($tool->image) {
                Storage::disk('public')->delete($tool->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $tool->update([
            'name' => $request->name,
            'stock' => $request->stock,
            'rental_price' => $request->rental_price,
            'description' => $request->description,
            'image' => isset($imagePath) ? $imagePath : $tool->image,
        ]);

        return redirect()->route('tools.index')->with('success', 'Tool updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tool $tool)
    {
        // check apakah tools sedang dipinjam atau tidak
        $borrowings = Borrowing::where('tool_id', $tool->id)->where('status', 'borrowed', 'pending')->get();

        if ($borrowings->count() > 0) {
            return redirect()->route('tools.index')->with('error', 'Tool cannot be deleted because it is currently borrowed.');
        }

        // delete image
        if ($tool->image) {
            Storage::disk('public')->delete($tool->image);
        }
        $tool->delete();
        return redirect()->route('tools.index')->with('success', 'Tool deleted successfully.');
    }
}
