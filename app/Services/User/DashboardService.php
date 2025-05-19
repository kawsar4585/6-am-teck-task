<?php

namespace App\Services\User;

class DashboardService
{
    public function getDashboardData()
    {
        $data['message'] = 'Welcome to the User Dashboard';

        return $data;
    }
}
