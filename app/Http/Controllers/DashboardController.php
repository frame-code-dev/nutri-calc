<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Menu;
use App\Models\RawMaterial;
use App\Models\Stock;
use App\Models\User;
use App\Services\NutritionCalculator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $nutritionCalculator;

    public function __construct(NutritionCalculator $nutritionCalculator)
    {
        $this->nutritionCalculator = $nutritionCalculator;
    }

    public function admin()
    {
        // Check permissions
        if (!auth()->user()->can('view admin dashboard') && !auth()->user()->hasRole('Ahli Gizi')) {
            abort(403);
        }

        return view('dashboard.admin');
    }

    /**
     * Admin Statistics Dashboard
     */
    public function statistics()
    {
        // Check permissions
        if (!auth()->user()->can('view admin dashboard') && !auth()->user()->hasRole('Ahli Gizi')) {
            abort(403);
        }

        // Statistics
        $stats = [
            'total_schools' => School::where('is_active', true)->count(),
            'total_students' => School::where('is_active', true)->sum('student_count'),
            'total_menus' => Menu::where('is_active', true)->count(),
            'total_materials' => RawMaterial::where('is_active', true)->count(),
            'total_users' => User::count(),
        ];

        // Recent activities (last 7 days)
        $recentStocks = Stock::with('rawMaterial', 'supplier', 'creator')
            ->where('transaction_date', '>=', Carbon::now()->subDays(7))
            ->latest('transaction_date')
            ->limit(10)
            ->get();

        // Low stock alerts
        $lowStockMaterials = collect([]);
        $materials = RawMaterial::where('is_active', true)->get();
        foreach ($materials as $material) {
            $currentStock = $material->getCurrentStock();
            // Alert if stock < 10kg/L or 10 units
            if ($currentStock < 10000) {
                $lowStockMaterials->push([
                    'material' => $material,
                    'current_stock' => $currentStock,
                ]);
            }
        }

        // Schools without coordinators
        $schoolsWithoutCoordinators = School::where('is_active', true)
            ->doesntHave('coordinators')
            ->get();

        // Chart Data: Stock trends (last 7 days)
        $stockTrends = Stock::selectRaw('DATE(transaction_date) as date, type, SUM(quantity) as total')
            ->where('transaction_date', '>=', now()->subDays(7))
            ->groupBy('date', 'type')
            ->orderBy('date')
            ->get();

        $chartLabels = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('d M'))->toArray();
        $stockInData = array_fill(0, 7, 0);
        $stockOutData = array_fill(0, 7, 0);

        foreach ($stockTrends as $trend) {
            $dayIndex = 6 - now()->diffInDays($trend->date);
            if ($dayIndex >= 0 && $dayIndex < 7) {
                if ($trend->type === 'in') {
                    $stockInData[$dayIndex] = $trend->total;
                } else {
                    $stockOutData[$dayIndex] = $trend->total;
                }
            }
        }

        // Chart Data: Menu type distribution
        $wetCount = Menu::where('type', 'wet')->where('is_active', true)->count();
        $dryCount = Menu::where('type', 'dry')->where('is_active', true)->count();
        $totalMenus = $wetCount + $dryCount;
        
        $menuDistribution = [
            'wet' => $wetCount,
            'dry' => $dryCount,
            'wet_percentage' => $totalMenus > 0 ? round(($wetCount / $totalMenus) * 100) : 0,
            'dry_percentage' => $totalMenus > 0 ? round(($dryCount / $totalMenus) * 100) : 0,
        ];

        return view('dashboard.statistics', compact(
            'stats',
            'recentStocks',
            'lowStockMaterials',
            'schoolsWithoutCoordinators',
            'chartLabels',
            'stockInData',
            'stockOutData',
            'menuDistribution'
        ));
    }

    /**
     * School Coordinator Dashboard
     */
    public function coordinator()
    {
        $user = auth()->user();
        
        // Get coordinator's school
        $coordinator = $user->schoolCoordinator;
        
        if (!$coordinator) {
            return view('dashboard.coordinator-no-school');
        }

        $school = $coordinator->school;

        // Get upcoming week menus
        $upcomingCalendars = $school->calendars()
            ->where('date', '>=', now())
            ->with('menu')
            ->orderBy('date')
            ->limit(7)
            ->get();

        return view('dashboard.coordinator', compact('school', 'upcomingCalendars'));
    }

    /**
     * Kitchen/Production Coordinator Dashboard
     */
    public function kitchen()
    {
        // Tomorrow's production menu
        $tomorrow = Carbon::tomorrow();
        
        // Get all calendars for tomorrow where status is 'receive'
        $tomorrowProduction = \App\Models\SchoolCalendar::where('date', $tomorrow->toDateString())
            ->where('day_status', 'receive')
            ->with('school', 'menu.menuItems.rawMaterial')
            ->get();

        // Calculate total raw material needs
        $materialNeeds = [];
        foreach ($tomorrowProduction as $calendar) {
            if ($calendar->menu) {
                foreach ($calendar->menu->menuItems as $item) {
                    $materialId = $item->raw_material_id;
                    $needed = $item->quantity_per_portion * $calendar->portion_count;
                    
                    if (isset($materialNeeds[$materialId])) {
                        $materialNeeds[$materialId]['total_needed'] += $needed;
                    } else {
                        $materialNeeds[$materialId] = [
                            'material' => $item->rawMaterial,
                            'total_needed' => $needed,
                            'current_stock' => $item->rawMaterial->getCurrentStock(),
                        ];
                    }
                }
            }
        }

        return view('dashboard.kitchen', compact('tomorrowProduction', 'materialNeeds'));
    }

    /**
     * Supplier Dashboard
     */
    public function supplier()
    {
        $user = auth()->user();
        
        // This is a simplified version - in production, you'd link user to supplier
        $mySupplies = Stock::where('created_by', $user->id)
            ->with('rawMaterial')
            ->latest('transaction_date')
            ->limit(20)
            ->get();

        return view('dashboard.supplier', compact('mySupplies'));
    }

    /**
     * Main dashboard router
     */
    public function index()
    {
        $user = auth()->user();

        // Route to appropriate dashboard based on role
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin MBG') || $user->hasRole('Ahli Gizi')) {
            return $this->admin();
        } elseif ($user->hasRole('Koordinator Sekolah')) {
            return $this->coordinator();
        } elseif ($user->hasRole('Koordinator Dapur')) {
            return $this->kitchen();
        } elseif ($user->hasRole('Supplier')) {
            return $this->supplier();
        }

        // Default fallback
        return view('dashboard.default');
    }
}
