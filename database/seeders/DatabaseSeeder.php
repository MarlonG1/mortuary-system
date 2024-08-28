<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Office;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Office::create([
            'location' => 'Test',
        ]);

        Employee::create([
            'office_id' => 1,
            'name' => 'Marlon',
            'lastname' => 'Hernandez',
            'phone' => '7614-4843',
            'birth_date' => '2003-11-11',
            'dui' => '06611947-7',
        ]);

        User::create([
            'employee_id' => 1,
            'username' => 'marlonhg',
            'email' => 'marlon.hg2003@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        $this->call([
            CategorySeeder::class,
            OfficesSeeder::class,
            EmployeeSeeder::class,
            CustomerSeeder::class,

//            ProductSeeder::class,

            ServicesSeeder::class,

//            SalesSeeder::class,

        ]);
    }
}
