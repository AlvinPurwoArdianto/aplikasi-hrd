<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Penggajian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Fetch all Pegawai data
        $pegawai = Pegawai::all();
        
        $totalPegawai = $pegawai->count(); // Count total employees directly from the collection
        $totalPenggajian = Pegawai::sum('gaji'); // Assuming gaji is in the pegawais table
        
        // Fetch available years for selection
        $availableYears = Penggajian::selectRaw('YEAR(tanggal_gaji) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        
        // Get the selected year from the request or use the current year
        $selectedYear = $request->input('year', Carbon::now()->year);
        
        // Fetch expenditure per month for the selected year
        $pengeluaranPerBulan = Penggajian::selectRaw('MONTH(tanggal_gaji) as bulan, SUM(jumlah_gaji + bonus - potongan) as total_pengeluaran')
            ->whereYear('tanggal_gaji', $selectedYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total_pengeluaran', 'bulan')
            ->toArray();
        
        // Initialize array for all months of the year
        $allMonths = [];
        for ($month = 1; $month <= 12; $month++) {
            $allMonths[date('F', mktime(0, 0, 0, $month, 1))] = $pengeluaranPerBulan[$month] ?? 0;
        }
        
        // Calculate yearly growth percentage
        $growthData = [];
        for ($year = $selectedYear - 1; $year <= $selectedYear; $year++) {
            $previousTotal = Penggajian::whereYear('tanggal_gaji', $year - 1)
                ->selectRaw('SUM(jumlah_gaji + bonus - potongan) as total')
                ->value('total');
        
            $currentTotal = Penggajian::whereYear('tanggal_gaji', $year)
                ->selectRaw('SUM(jumlah_gaji + bonus - potongan) as total')
                ->value('total');
        
            // Calculate growth percentage
            if ($previousTotal > 0) {
                $growthPercentage = (($currentTotal - $previousTotal) / $previousTotal) * 100;
            } else {
                $growthPercentage = $currentTotal > 0 ? 100 : 0; // New data case
            }
        
            $growthData[$year] = $growthPercentage;
        }
    
        // Prepare data for the donut chart
        $growthPercentages = array_values($growthData);
        
        // Return view with all necessary data
        return view('home', compact('pegawai', 'totalPegawai', 'totalPenggajian', 'allMonths', 'availableYears', 'selectedYear', 'growthData', 'growthPercentages'));
    }
    
    
}
