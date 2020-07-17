<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        $customers = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'customer');
        })->latest()->get();

        $customers = $customers->map(function ($customer) {
            $customer->metadatas = [];
            foreach ($customer->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $customer->metadatas = array_merge($customer->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($customer->metadata);

            return $customer;
        });

        return $customers;
    }
}
