<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        if(User::count() === 1) {
            $this->call(UserSeeder::class);
        }

        if(Customer::count() === 0) {
            $this->call(CustomerSeeder::class);
        }

        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        if (Brand::count() === 0) {
            $this->call(BrandSeeder::class);
        }


        if (Product::count() === 0) {
            $this->call(ProductSeeder::class);
        }

        if (Order::count() === 0) {
            $this->call(OrderSeeder::class);
        }
    }
}
