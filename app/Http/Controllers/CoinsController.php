<?php

namespace App\Http\Controllers;

use App\Models\Coins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoinsController extends Controller
{
    /**
     * Display a listing of the coins.
     */
    public function index()
    {
        $coins = Coins::paginate(10);
        return view('coins.index', compact('coins'));
    }

    /**
     * Store a newly created coin record in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coins_total' => 'required|numeric|min:0',
            'coins_earned' => 'nullable|numeric|min:0',
        ]);
   
        if ($validator->fails()) {
            return redirect()->route('coins.index')
                ->withErrors($validator)
                ->withInput();
        }
   
        $coins_id = 'CN' . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
   
        $coinsData = [
            'coins_id' => $coins_id,
            'coins_total' => $request->input('coins_total'),
            'coins_earned' => $request->input('coins_earned') ?? 0,
        ];
   
        Coins::create($coinsData);
   
        return redirect()->route('coins.index')
            ->with('success', 'Coins berhasil ditambahkan.');
    }
   
    /**
     * Display the specified coin record.
     */
    public function show(string $id)
    {
        try {
            $coin = Coins::where('coins_id', $id)->firstOrFail();
            return view('coins.show', compact('coin'));
        } catch (\Exception $e) {
            return redirect()->route('coins.index')
                ->with('error', 'Coins tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified coin record.
     */
    public function edit(string $id)
    {
        try {
            $coin = Coins::where('coins_id', $id)->firstOrFail();
            return view('coins.edit', compact('coin'));
        } catch (\Exception $e) {
            return redirect()->route('coins.index')
                ->with('error', 'Coins tidak ditemukan.');
        }
    }

    /**
     * Update the specified coin record in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $coin = Coins::where('coins_id', $id)->firstOrFail();
       
            $validator = Validator::make($request->all(), [
                'coins_total' => 'required|numeric|min:0',
                'coins_earned' => 'nullable|numeric|min:0',
            ]);
       
            if ($validator->fails()) {
                return redirect()->route('coins.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
       
            $coinsData = [
                'coins_total' => $request->input('coins_total'),
                'coins_earned' => $request->input('coins_earned') ?? 0,
            ];
       
            $coin->update($coinsData);
       
            return redirect()->route('coins.index')
                ->with('success', 'Coins berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('coins.index')
                ->with('error', 'Gagal memperbarui coins: ' . $e->getMessage());
        }
    }
   
    /**
     * Remove the specified coin record from storage.
     */
    public function destroy(string $id)
    {
        try {
            $coin = Coins::where('coins_id', $id)->firstOrFail();
            $coin->delete();
    
            return redirect()->route('coins.index')
                ->with('success', 'Coins berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('coins.index')
                ->with('error', 'Gagal menghapus coins: ' . $e->getMessage());
        }
    }
}