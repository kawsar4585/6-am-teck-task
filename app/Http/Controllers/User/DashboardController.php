<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\User\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Home', route('user.dashboard'), 'fa fa-home');
    }

    public function index(DashboardService $dashboardService)
    {
        $this->setPageTitle("Dashboard");
        $this->setPageHeaderTitle("Dashboard");
        $this->setActiveMenu('dashboard');
        $data = $dashboardService->getDashboardData();
        return $this->view('user.index')->with($data);
    }
}
