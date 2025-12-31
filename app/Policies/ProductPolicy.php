<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Product;

class ProductPolicy
{
    public function update(Admin $admin, Product $product)
    {
        return $admin->id === $product->admin_id;
    }

    public function delete(Admin $admin, Product $product)
    {
        return $admin->id === $product->admin_id;
    }
}
