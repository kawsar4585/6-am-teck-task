<?php

namespace App\Traits;

use App\Enums\Deleted;
use App\Enums\Status;
use App\Models\User;

trait DashboardDataTrait
{
    private function totalUserData()
    {
        $data['activeUsers'] = User::where('deleted', Deleted::NO->value)
            ->where('status', Status::ACTIVE->value)
            ->count();

        $data['inactiveUsers'] = User::where('deleted', Deleted::NO->value)
            ->where('status', Status::INACTIVE->value)
            ->count();

        return $data;
    }
}
