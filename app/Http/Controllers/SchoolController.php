<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolCoordinator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function __construct()
    {
        // Middleware handled in routes
    }

    /**
     * Display a listing of schools
     */
    public function index(Request $request)
    {
        // 1. Base Query with filters only
        $query = School::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }else{
            $query->where('is_active', true);
        }

        // 2. Stats Query (Clone base query, no eager loads)
        $totals = [
            'small_portions' => 0,
            'large_portions' => 0,
            'teachers' => 0,
            'overall' => 0
        ];

        try {
            $stats = (clone $query)->selectRaw('
                SUM(small_portion_count) as total_small,
                SUM(large_portion_count) as total_large,
                SUM(teacher_count) as total_teacher
            ')->first();

            $totals = [
                'small_portions' => $stats->total_small ?? 0,
                'large_portions' => $stats->total_large ?? 0,
                'teachers' => $stats->total_teacher ?? 0,
                'overall' => ($stats->total_small ?? 0) + ($stats->total_large ?? 0) + ($stats->total_teacher ?? 0)
            ];
        } catch (\Exception $e) {
            // Fallback or log error if needed
        }

        // 3. Main Query (Add relations and pagination)
        $schools = $query->withCount('coordinators')
            ->with('coordinators')
            ->latest()
            ->paginate(10);

        return view('schools.index', compact('schools', 'totals'));
    }

    /**
     * Show the form for creating a new school
     */
    public function create()
    {
        return view('schools.create');
    }

    /**
     * Store a newly created school
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'small_portion_count' => 'required|integer|min:0',
            'large_portion_count' => 'required|integer|min:0',
            'teacher_count' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['student_count'] = $validated['small_portion_count'] + $validated['large_portion_count'];

        $school = School::create($validated);

        return redirect()->route('schools.show', $school)
            ->with('success', 'Sekolah berhasil ditambahkan!');
    }

    /**
     * Display the specified school
     */
    public function show(School $school)
    {
        $school->load('coordinators', 'calendars', 'rabs');
        
        // Get upcoming calendars
        $upcomingCalendars = $school->calendars()
            ->where('date', '>=', now())
            ->with('menu')
            ->orderBy('date')
            ->limit(7)
            ->get();

        return view('schools.show', compact('school', 'upcomingCalendars'));
    }

    /**
     * Show the form for editing the specified school
     */
    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    /**
     * Update the specified school
     */
    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'small_portion_count' => 'required|integer|min:0',
            'large_portion_count' => 'required|integer|min:0',
            'teacher_count' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['student_count'] = $validated['small_portion_count'] + $validated['large_portion_count'];

        $school->update($validated);

        return redirect()->route('schools.show', $school)
            ->with('success', 'Data sekolah berhasil diperbarui!');
    }

    /**
     * Remove the specified school
     */
    public function destroy(School $school)
    {
        // Check if school has dependencies
        if ($school->coordinators()->count() > 0 || $school->calendars()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus sekolah yang memiliki koordinator atau jadwal!');
        }

        $school->delete();

        return redirect()->route('schools.index')
            ->with('success', 'Sekolah berhasil dihapus!');
    }

    /**
     * Toggle school active status
     */
    public function toggleStatus(School $school)
    {
        $school->update(['is_active' => !$school->is_active]);
        
        $status = $school->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "Sekolah berhasil {$status}!");
    }

    /**
     * Get coordinators for a specific school
     */
    public function coordinators(School $school)
    {
        $coordinators = $school->coordinators()->with('user')->get();
        $availableUsers = User::role('Koordinator Sekolah')
            ->whereDoesntHave('schoolCoordinator')
            ->get();

        return view('schools.coordinators', compact('school', 'coordinators', 'availableUsers'));
    }

    /**
     * Add coordinator to school
     */
    public function addCoordinator(Request $request, School $school)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'is_active' => 'boolean',
        ]);

        SchoolCoordinator::create(array_merge(
            ['school_id' => $school->id],
            $validated
        ));

        return back()->with('success', 'Koordinator berhasil ditambahkan!');
    }
}
