<?php

namespace App\Livewire\Components;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Office;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Service;
use Livewire\Component;

class Dashboard extends Component
{
    public $salesByMonth = [], $salesByWeek = [], $servicesAvailable = [];
    public $mapInformation = [];
public function mount()
{
    $this->initializeSalesData();
    $this->initializeServiceData();
    $this->initializeOfficeData();
    $this->prepareChartData();
}

private function initializeSalesData()
{
    $currentYear = date('Y');
    $currentWeek = date('W');

    $this->salesByMonth = Sale::selectRaw('MONTH(sale_date) as month, SUM(total) as total')
        ->whereYear('sale_date', $currentYear)
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function ($sale) {
            return [$sale->month => $sale->total];
        })
        ->toArray();

    $salesWeek = Sale::selectRaw('DAYOFWEEK(sale_date) as day, SUM(total) as total')
        ->whereYear('sale_date', $currentYear)
        ->whereRaw('WEEK(sale_date, 1) = ?', [$currentWeek])
        ->groupBy('day')
        ->orderBy('day')
        ->get();

    $this->salesByWeek = array_fill(1, 6, 0);
    foreach ($salesWeek as $sale) {
        if ($sale->day == 1) {
            $this->salesByWeek[7] = $sale->total;
        } else {
            $this->salesByWeek[$sale->day - 1] = $sale->total;
        }
    }

    ksort($this->salesByMonth);
    ksort($this->salesByWeek);

    $this->salesByMonth = array_values($this->salesByMonth);
    $this->salesByWeek = array_values($this->salesByWeek);
}

private function initializeServiceData()
{
    $servAvailable = Service::selectRaw('COUNT(id) as count')
        ->where('available', 1)
        ->get();

    $servDisable = Service::selectRaw('COUNT(id) as count')
        ->where('available', 0)
        ->get();

    $this->servicesAvailable = array_values([
        'available' => $servAvailable[0]->count,
        'disable' => $servDisable[0]->count,
    ]);
}

private function initializeOfficeData()
{
    $offices = Office::select('location')->get();
    $this->mapInformation['locations'] = $offices->map(function ($office) {
        return $office->location;
    })->toArray();

    $this->mapInformation['salesByOffice'] = $this->getCountByOffice(Sale::class);
    $this->mapInformation['employeesByOffice'] = $this->getCountByOffice(Employee::class);
    $this->mapInformation['profitsByOffice'] = $this->getSumByOffice(Sale::class, 'total');
}

private function getCountByOffice($model)
{
    $counts = $model::selectRaw('office_id, COUNT(id) as count')
        ->groupBy('office_id')
        ->get();

    $result = array_fill(0, 15, 0);
    foreach ($counts as $count) {
        $result[$count->office_id - 1] = $count->count;
    }

    return $result;
}

private function getSumByOffice($model, $column)
{
    $sums = $model::selectRaw('office_id, SUM(' . $column . ') as total')
        ->groupBy('office_id')
        ->get();

    $result = array_fill(0, 15, 0);
    foreach ($sums as $sum) {
        $result[$sum->office_id - 1] = round($sum->total,2);
    }

    return $result;
}

private function prepareChartData()
{
    $this->mapInformation = array_values($this->mapInformation);
}

    public function render()
    {
        $totalProfit = round(Sale::sum('total'), 2);

        if ($totalProfit > 1000) {
            $totalProfit = round($totalProfit / 1000, 2) . 'k';
        }

        return view('livewire.components.dashboard', [
            'totalSales' => Sale::count('id'),
            'totalCustomers' => Customer::count('id'),
            'totalProducts' => Product::count('id'),
            'totalProfit' => $totalProfit,
            'latestSales' => Sale::latest()->take(6)->orderBy('id', 'desc')->get(),
        ]);
    }
}
