<?php

namespace App\Http\Controllers;

use App\Models\exchange_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExchangeItemController extends Controller
{
    /**
     * Display a listing of the exchange items.
     */
    public function index()
    {
        $exchangeItems = exchange_item::paginate(10);
        return view('exchange_items.index', compact('exchangeItems'));
    }

    /**
     * Store a newly created exchange item in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|max:255',
            'location' => 'required|max:255',
            'item_quantity' => 'required|integer|min:1',
        ]);
   
        if ($validator->fails()) {
            return redirect()->route('exchange_items.index')
                ->withErrors($validator)
                ->withInput();
        }
   
        $id_item = 'EI' . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
   
        $exchangeItemData = [
            'id_item' => $id_item,
            'item_name' => $request->input('item_name'),
            'location' => $request->input('location'),
            'item_quantity' => $request->input('item_quantity'),
        ];
   
        exchange_item::create($exchangeItemData);
   
        return redirect()->route('exchange_items.index')
            ->with('success', 'Item exchange berhasil ditambahkan.');
    }
   
    /**
     * Display the specified exchange item.
     */
    public function show(string $id)
    {
        try {
            $exchangeItem = exchange_item::where('id_item', $id)->firstOrFail();
            return view('exchange_items.show', compact('exchangeItem'));
        } catch (\Exception $e) {
            return redirect()->route('exchange_items.index')
                ->with('error', 'Item exchange tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified exchange item.
     */
    public function edit(string $id)
    {
        try {
            $exchangeItem = exchange_item::where('id_item', $id)->firstOrFail();
            return view('exchange_items.edit', compact('exchangeItem'));
        } catch (\Exception $e) {
            return redirect()->route('exchange_items.index')
                ->with('error', 'Item exchange tidak ditemukan.');
        }
    }

    /**
     * Update the specified exchange item in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $exchangeItem = exchange_item::where('id_item', $id)->firstOrFail();
       
            $validator = Validator::make($request->all(), [
                'item_name' => 'required|max:255',
                'location' => 'required|max:255',
                'item_quantity' => 'required|integer|min:1',
            ]);
       
            if ($validator->fails()) {
                return redirect()->route('exchange_items.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
       
            $exchangeItemData = [
                'item_name' => $request->input('item_name'),
                'location' => $request->input('location'),
                'item_quantity' => $request->input('item_quantity'),
            ];
       
            $exchangeItem->update($exchangeItemData);
       
            return redirect()->route('exchange_items.index')
                ->with('success', 'Item exchange berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('exchange_items.index')
                ->with('error', 'Gagal memperbarui item exchange: ' . $e->getMessage());
        }
    }
   
    /**
     * Remove the specified exchange item from storage.
     */
    public function destroy(string $id)
    {
        try {
            $exchangeItem = exchange_item::where('id_item', $id)->firstOrFail();
            $exchangeItem->delete();
    
            return redirect()->route('exchange_items.index')
                ->with('success', 'Item exchange berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('exchange_items.index')
                ->with('error', 'Gagal menghapus item exchange: ' . $e->getMessage());
        }
    }
}
