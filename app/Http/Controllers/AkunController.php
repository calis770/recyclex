<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\LevelAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Akun::with('level');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by level
        if ($request->has('level') && !empty($request->level)) {
            $query->where('id_level', $request->level);
        }
        
        $akuns = $query->orderBy('created_at', 'desc')->paginate(10);
        $levels = LevelAkun::all();
        
        return view('akun.index', compact('akuns', 'levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = LevelAkun::all();
        return view('akun.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:akun,email',
            'phone' => 'required|string|max:15|unique:akun,phone',
            'password' => 'required|string|min:8|confirmed',
            'id_level' => 'required|exists:level_akun,id_level',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Generate custom ID
            $id_akun = 'U' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            
            $akun = Akun::create([
                'id_akun' => $id_akun,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'id_level' => $request->id_level,
            ]);

            return redirect()->route('akun.index')
                           ->with('success', 'Akun berhasil dibuat.');
                           
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $akun = Akun::with('level')->findOrFail($id);
        return view('akun.show', compact('akun'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $akun = Akun::findOrFail($id);
        $levels = LevelAkun::all();
        return view('akun.edit', compact('akun', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $akun = Akun::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:akun,email,' . $id . ',id_akun',
            'phone' => 'required|string|max:15|unique:akun,phone,' . $id . ',id_akun',
            'password' => 'nullable|string|min:8|confirmed',
            'id_level' => 'required|exists:level_akun,id_level',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'id_level' => $request->id_level,
            ];

            // Only update password if provided
            if (!empty($request->password)) {
                $updateData['password'] = Hash::make($request->password);
            }

            $akun->update($updateData);

            return redirect()->route('akun.index')
                           ->with('success', 'Akun berhasil diperbarui.');
                           
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $akun = Akun::findOrFail($id);
            $akun->delete();

            return redirect()->route('akun.index')
                           ->with('success', 'Akun berhasil dihapus.');
                           
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle account status (activate/deactivate)
     */
    public function toggleStatus(string $id)
    {
        try {
            $akun = Akun::findOrFail($id);
            
            // Assuming you have an 'is_active' field or similar
            // If not, you can add this field to your migration
            $akun->is_active = !$akun->is_active;
            $akun->save();

            $status = $akun->is_active ? 'diaktifkan' : 'dinonaktifkan';
            
            return redirect()->route('akun.index')
                           ->with('success', "Akun berhasil {$status}.");
                           
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get accounts by level (for AJAX requests)
     */
    public function getByLevel(Request $request)
    {
        $level = $request->get('level');
        $akuns = Akun::with('level')->where('id_level', $level)->get();
        
        return response()->json($akuns);
    }

    /**
     * Search accounts (for AJAX requests)
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        $akuns = Akun::with('level')
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->limit(10)
                    ->get();
        
        return response()->json($akuns);
    }

    /**
     * Generate custom account ID
     */
    private function generateAkunId()
    {
        do {
            // Generate ID format: AK + random string (total 20 chars)
            $id = 'AK' . strtoupper(Str::random(18));
        } while (Akun::where('id_akun', $id)->exists());
        
        return $id;
    }

    /**
     * Reset password
     */
    public function resetPassword(string $id)
    {
        try {
            $akun = Akun::findOrFail($id);
            
            // Generate temporary password
            $tempPassword = Str::random(10);
            $akun->update([
                'password' => Hash::make($tempPassword),
                'email_verified_at' => null, // Force email verification
            ]);

            // You can send email with temporary password here
            // Mail::to($akun->email)->send(new ResetPasswordMail($tempPassword));

            return redirect()->route('akun.index')
                           ->with('success', "Password berhasil direset. Password sementara: {$tempPassword}");
                           
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Verify email manually
     */
    public function verifyEmail(string $id)
    {
        try {
            $akun = Akun::findOrFail($id);
            $akun->update([
                'email_verified_at' => now(),
            ]);

            return redirect()->route('akun.index')
                           ->with('success', 'Email berhasil diverifikasi.');
                           
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete accounts
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:akun,id_akun',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $count = Akun::whereIn('id_akun', $request->ids)->delete();
            
            return redirect()->route('akun.index')
                           ->with('success', "{$count} akun berhasil dihapus.");
                           
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Export accounts to CSV
     */
    public function export(Request $request)
    {
        $query = Akun::with('level');
        
        // Apply same filters as index
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->has('level') && !empty($request->level)) {
            $query->where('id_level', $request->level);
        }
        
        $akuns = $query->get();
        
        $filename = 'akun_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function() use ($akuns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID Akun', 'Nama', 'Email', 'Telepon', 'Level', 'Status Email', 'Dibuat']);
            
            foreach ($akuns as $akun) {
                fputcsv($file, [
                    $akun->id_akun,
                    $akun->name,
                    $akun->email,
                    $akun->phone,
                    $akun->getRoleName(),
                    $akun->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi',
                    $akun->created_at ? $akun->created_at->format('Y-m-d H:i:s') : 'N/A',
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}