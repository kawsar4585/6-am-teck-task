<?php

namespace Database\Seeders;

use App\Enums\Deleted;
use App\Enums\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->role = User::ROLE_ADMIN;
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->email_verified_at = Carbon::now();
        $admin->password = 123456;
        $admin->status = Status::ACTIVE->value;
        $admin->deleted = Deleted::NO->value;
        $admin->created_by = 1;
        $admin->created_at = Carbon::now();
        $admin->save();

        $user = new User();
        $user->role = User::ROLE_USER;
        $user->name = 'User';
        $user->email = 'user@gmail.com';
        $user->email_verified_at = Carbon::now();
        $user->password = 123456;
        $user->status = Status::ACTIVE->value;
        $user->deleted = Deleted::NO->value;
        $user->created_by = 1;
        $user->created_at = Carbon::now();
        $user->save();
    }
}
