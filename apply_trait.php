<?php
$dir = __DIR__ . '/app/Models';
$models = [
    'Category', 'Menu', 'RawMaterial', 'School', 'Supplier', 'Stock', 'Procurement', 'Relawan', 
    'SalarySetting', 'SalaryPeriod', 'SalaryDetail', 'SalaryComponent', 'SchoolDistribution', 
    'SchoolCalendar', 'SchoolWeeklyStatus', 'WeeklyLock', 'Kloter', 'DistributionUnit', 'Rab', 
    'RabDetail', 'MenuSchedule', 'MenuItem'
];

foreach ($models as $model) {
    $file = $dir . '/' . $model . '.php';
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        $changed = false;

        // Add import
        if (strpos($content, 'App\Models\Traits\HasSppg') === false) {
            $content = str_replace(
                "use Illuminate\Database\Eloquent\Model;", 
                "use Illuminate\Database\Eloquent\Model;\nuse App\Models\Traits\HasSppg;", 
                $content
            );
            $changed = true;
        }

        // Add trait use
        if (strpos($content, 'use HasSppg;') === false && strpos($content, 'HasSppg,') === false && strpos($content, ', HasSppg') === false) {
            if (strpos($content, 'use HasFactory;') !== false) {
                $content = str_replace('use HasFactory;', 'use HasFactory, HasSppg;', $content);
            } else {
                $content = preg_replace('/class\s+'.$model.'\s+extends[^{]+\{\s*/', "$0use HasSppg;\n    ", $content);
            }
            $changed = true;
        }

        if ($changed) {
            file_put_contents($file, $content);
            echo "Updated $model\n";
        } else {
            echo "No change needed for $model\n";
        }
    } else {
        echo "File not found: $model\n";
    }
}
