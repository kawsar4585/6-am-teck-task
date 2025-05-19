<?php

namespace App\Services\Admin;

use App\Traits\DashboardDataTrait;

class DashboardService
{
    use DashboardDataTrait;

    public function getDashboardData()
    {
        $data = [
            'message' => 'Welcome to the Admin Dashboard',
            'totalUsers' => $this->totalUserData(),
        ];

        return $data;
    }
}
