<?php

namespace App\Controllers;

use App\Models\PackageModel;
use App\Models\RegionModel;
use App\Models\NationalSummaryModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $role = session()->get('role');
        $region_key = session()->get('region_key');

        if ($role === 'superadmin') {
            return $this->superAdminDashboard();
        } elseif ($role === 'bupati') {
            return $this->bupatiDashboard($region_key);
        }

        return redirect()->to('/login');
    }

    private function superAdminDashboard()
    {
        $summaryModel = new NationalSummaryModel();
        $regionModel = new RegionModel();
        
        $data = [
            'title' => 'Dashboard Super Admin - Nemesis',
            'summary' => $summaryModel->first(),
            'regions' => $regionModel->join('region_metrics', 'region_metrics.region_key = regions.region_key')->findAll()
        ];

        return view('dashboard/superadmin', $data);
    }

    private function bupatiDashboard($region_key)
    {
        $regionModel = new RegionModel();
        $packageModel = new PackageModel();

        $region = $regionModel->join('region_metrics', 'region_metrics.region_key = regions.region_key')
                             ->where('regions.region_key', $region_key)
                             ->first();

        if (! $region) {
            return "Region data not found.";
        }

        $data = [
            'title' => 'Dashboard Bupati - ' . $region['display_name'],
            'region' => $region,
            'priority_packages' => $packageModel->join('package_regions', 'package_regions.package_id = packages.id')
                                               ->where('package_regions.region_key', $region_key)
                                               ->where('is_priority', 1)
                                               ->findAll()
        ];

        return view('dashboard/bupati', $data);
    }
}
