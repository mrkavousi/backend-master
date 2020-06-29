<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Seeding Roles and Permissions
        // Note that to add new role, make sure you put it at the end of roles below to prevent changing existing roles id.
        // And for best refreshed state of roles, truncate tables 'roles', 'permissions' and 'permission_role' and run this seeder.
        //

        // Admin Role
        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = 'Admin';
        $admin->description = 'All System Admin';
        if (!$adminExists = Role::where('name', $admin->name)->get()->first())
            $admin->save();
        // Admin Permissions
        $admin_permission_names = [
            // Admin
            ['name' => 'moderate-admin'],
            ['name' => 'admin-access'],
            // Users
            ['name' => 'moderate-all-users'],
            ['name' => 'view-all-users'],
            ['name' => 'edit-all-users'],
            ['name' => 'delete-all-users'],
            ['name' => 'add-user'],
        ];

        // Support Role
        $support = new Role();
        $support->name = 'support';
        $support->display_name = 'Support';
        $support->description = 'Support and Monitoring';
        if (!$supportExists = Role::where('name', $support->name)->get()->first())
            $support->save();
        // Support Permissions
        $support_permission_names = [
            // Admin
            ['name' => 'admin-access'],
            // Users
            ['name' => 'moderate-all-users'],
            ['name' => 'view-all-users'],
            ['name' => 'edit-all-users'],
        ];

        // Expert Role
        $expert = new Role();
        $expert->name = 'expert';
        $expert->display_name = 'Expert';
        $expert->description = 'Experts';
        if (!$expertExists = Role::where('name', $expert->name)->get()->first())
            $expert->save();
        // Expert Permissions
        $expert_permission_names = [];

        // Census Role
        $census = new Role();
        $census->name = 'census';
        $census->display_name = 'Census';
        $census->description = 'Censuses';
        if (!$censusExists = Role::where('name', $census->name)->get()->first())
            $census->save();
        // Census Permissions
        $census_permission_names = [];

        // Customer Role
        $customer = new Role();
        $customer->name = 'customer';
        $customer->display_name = 'Customer';
        $customer->description = 'Customer';
        if (!$customerExists = Role::where('name', $customer->name)->get()->first())
            $customer->save();
        // Customer Permissions
        $customer_permission_names = [];

        // Storage Observer Role
        $storageObserver = new Role();
        $storageObserver->name = 'storage-observer';
        $storageObserver->display_name = 'Storage Observer';
        $storageObserver->description = 'Storage Observers';
        if (!$storageObserverExists = Role::where('name', $storageObserver->name)->get()->first())
            $storageObserver->save();
        // Customer Permissions
        $storage_bserver_permission_names = [];

        // Recipient Role
        $recipient = new Role();
        $recipient->name = 'recipient';
        $recipient->display_name = 'Recipient';
        $recipient->description = 'Recipients';
        if (!$recipientExists = Role::where('name', $recipient->name)->get()->first())
            $recipient->save();
        // Recipient Permissions
        $recipient_permission_names = [];

        // Driver Role
        $driver = new Role();
        $driver->name = 'driver';
        $driver->display_name = 'Driver';
        $driver->description = 'Drives Vehicles';
        if (!$driverExists = Role::where('name', $driver->name)->get()->first())
            $driver->save();
        // Driver Permissions
        $driver_permission_names = [];

        // Operator Role
        $operator = new Role();
        $operator->name = 'operator';
        $operator->display_name = 'Operator';
        $operator->description = 'Operators on the site';
        if (!$operatorExists = Role::where('name', $operator->name)->get()->first())
            $operator->save();
        // Operator Permissions
        $operator_permission_names = [];

        // Worker Role
        $worker = new Role();
        $worker->name = 'worker';
        $worker->display_name = 'Worker';
        $worker->description = 'Workers';
        if (!$workerExists = Role::where('name', $worker->name)->get()->first())
            $worker->save();
        // Worker Permissions
        $worker_permission_names = [];

        // Blocked Role
        $blocked = new Role();
        $blocked->name = 'blocked';
        $blocked->display_name = 'Blocked';
        $blocked->description = 'Users who has been blocked';
        if (!$blockedExists = Role::where('name', $blocked->name)->get()->first())
            $blocked->save();
        // Blocked Permissions
        $blocked_permission_names = [];


        // Adding Permissions to Roles
        $this->add_permissions($admin_permission_names, $admin);
        $this->add_permissions($support_permission_names, $support);
        $this->add_permissions($expert_permission_names, $expert);
        $this->add_permissions($census_permission_names, $census);
        $this->add_permissions($customer_permission_names, $customer);
        $this->add_permissions($storage_bserver_permission_names, $storageObserver);
        $this->add_permissions($recipient_permission_names, $recipient);
        $this->add_permissions($driver_permission_names, $driver);
        $this->add_permissions($operator_permission_names, $operator);
        $this->add_permissions($worker_permission_names, $worker);
        $this->add_permissions($blocked_permission_names, $blocked);
    }

    public function add_permissions($permission_names, $role)
    {
        $permissions = [];
        foreach ($permission_names as $p) {
            if (!$permission = Permission::where('name', $p['name'])->get()->first())
                $permission = Permission::create($p);

            array_push($permissions, $permission);
        }

        // If The Role Just Created Right Now, Attach Permissions to Role
        if ($role->id)
            $role->attachPermissions($permissions);
    }
}
