<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\Admin\DashboardService;

class DashboardController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Home', route('admin.dashboard'), 'fa fa-home');
    }

    public function index(DashboardService $dashboardService)
    {
        $this->setPageTitle("Dashboard");
        $this->setPageHeaderTitle("Dashboard");
        $this->setActiveMenu('dashboard');
        $data = $dashboardService->getDashboardData();
        return $this->view('admin.index')->with($data);
    }
}
