<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAdmin()
    {
        return view('index');
    }
    public function index()
    {
        $orders = Order::all();
        return view('view_orders', compact('orders'));
    }

    public function create()
    {
        return view('tambah_orders');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('orders', 'public');
        }

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order berhasil ditambahkan!');
    }

    public function edit(Order $order)
    {
        return view('edit_orders', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($order->gambar) {
                Storage::delete('public/' . $order->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('orders', 'public');
        }

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order berhasil diperbarui!');
    }

    public function destroy(Order $order)
    {
        if ($order->order_image) {
            Storage::delete('public/' . $order->order_image);
        }
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order berhasil dihapus!');
    }
}
