<?php

namespace App\Http\Controllers;

use App\Models\MasterSppg;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterSppgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sppgs = MasterSppg::all();
        return view('master-sppg.index', compact('sppgs'));
    }
     public function create()
    {
        $users = User::whereNull('sppg_id')->get();
        return view('master-sppg.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'instagram'  => 'nullable|string|max:255',
            'tiktok'     => 'nullable|string|max:255',
            'users'      => 'nullable|array',
            'users.*'    => 'exists:users,id',
        ]);

        DB::transaction(function () use ($validated) {

            $sppg = MasterSppg::create([
                'name'      => $validated['name'],
                'instagram' => $validated['instagram'] ?? null,
                'tiktok'    => $validated['tiktok'] ?? null,
            ]);

            // assign user ke sppg
            if (!empty($validated['users'])) {
                User::whereIn('id', $validated['users'])
                    ->update(['sppg_id' => $sppg->id]);
            }
        });

        return redirect()->route('master-sppg.index')
            ->with('success', 'Master SPPG berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterSppg $masterSppg)
    {
        $users = \App\Models\User::all(); // tampilkan semua user
        $assignedUsers = $masterSppg->users->pluck('id')->toArray();

        return view('master-sppg.edit', compact(
            'masterSppg',
            'users',
            'assignedUsers'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterSppg $masterSppg)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'instagram'  => 'nullable|string|max:255',
            'tiktok'     => 'nullable|string|max:255',
            'users'      => 'nullable|array',
            'users.*'    => 'exists:users,id',
        ]);

        DB::transaction(function () use ($validated, $masterSppg) {

            // Update master sppg
            $masterSppg->update([
                'name'      => $validated['name'],
                'instagram' => $validated['instagram'] ?? null,
                'tiktok'    => $validated['tiktok'] ?? null,
            ]);

            // 1️⃣ Unassign semua user lama
            \App\Models\User::where('sppg_id', $masterSppg->id)
                ->update(['sppg_id' => null]);

            // 2️⃣ Assign ulang sesuai pilihan baru
            if (!empty($validated['users'])) {
                \App\Models\User::whereIn('id', $validated['users'])
                    ->update(['sppg_id' => $masterSppg->id]);
            }
        });

        return redirect()->route('master-sppg.index')
            ->with('success', 'Master SPPG berhasil diupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterSppg $masterSppg)
    {
        DB::transaction(function () use ($masterSppg) {

            // 1️⃣ Unassign semua user yang punya sppg ini
            \App\Models\User::where('sppg_id', $masterSppg->id)
                ->update(['sppg_id' => null]);

            // 2️⃣ Hapus SPPG
            $masterSppg->delete();
        });

        return redirect()->route('master-sppg.index')
            ->with('success', 'Master SPPG berhasil dihapus');
    }

}
