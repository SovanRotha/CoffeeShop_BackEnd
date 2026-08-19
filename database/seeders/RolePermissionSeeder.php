<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Clear Permission Cache
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        /*
        |--------------------------------------------------------------------------
        | Get Roles
        |--------------------------------------------------------------------------
        */

        $admin = Role::findByName('admin');

        $manager = Role::findByName('manager');

        $cashier = Role::findByName('cashier');

        $barista = Role::findByName('barista');

        $employee = Role::findByName('employee');


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        | Admin can access EVERYTHING.
        */

        $admin->syncPermissions(
            Permission::all()
        );


        /*
        |--------------------------------------------------------------------------
        | MANAGER
        |--------------------------------------------------------------------------
        */

        $manager->syncPermissions([

            // Dashboard
            'dashboard.view',


            // Categories
            'categories.view',
            'categories.create',
            'categories.update',


            // Menu Items
            'menu_items.view',
            'menu_items.create',
            'menu_items.update',


            // Modifiers
            'modifiers.view',
            'modifiers.create',
            'modifiers.update',


            // Modifier Options
            'modifier_options.view',
            'modifier_options.create',
            'modifier_options.update',


            // Menu Item Modifiers
            'menu_item_modifiers.view',
            'menu_item_modifiers.create',
            'menu_item_modifiers.update',


            // Recipes
            'recipes.view',
            'recipes.create',
            'recipes.update',


            // Recipe Items
            'recipe_items.view',
            'recipe_items.create',
            'recipe_items.update',


            // Ingredient Categories
            'ingredient_categories.view',
            'ingredient_categories.create',
            'ingredient_categories.update',


            // Ingredients
            'ingredients.view',
            'ingredients.create',
            'ingredients.update',


            // Stock Adjustments
            'stock_adjustments.view',
            'stock_adjustments.create',
            'stock_adjustments.update',


            // Stock Logs
            'stock_logs.view',


            // Waste
            'waste_records.view',
            'waste_records.create',
            'waste_records.update',


            // Inventory
            'inventory.view',
            'inventory.adjust',
            'inventory.waste',


            // Suppliers
            'suppliers.view',
            'suppliers.create',
            'suppliers.update',


            // Purchases
            'purchases.view',
            'purchases.create',
            'purchases.update',
            'purchases.receive',
            'purchases.cancel',


            // Purchase Items
            'purchase_items.view',
            'purchase_items.create',
            'purchase_items.update',


            // Orders
            'orders.view',
            'orders.create',
            'orders.update',
            'orders.cancel',


            // Order Items
            'order_items.view',
            'order_items.create',
            'order_items.update',
            'order_items.delete',


            // Order Item Modifiers
            'order_item_modifiers.view',
            'order_item_modifiers.create',
            'order_item_modifiers.update',
            'order_item_modifiers.delete',


            // Payments
            'payments.view',
            'payments.create',
            'payments.update',
            'payments.refund',


            // Customers
            'customers.view',
            'customers.create',
            'customers.update',
            'customers.delete',


            // Employees
            'employees.view',
            'employees.create',
            'employees.update',


            // Attendance
            'attendance.view',
            'attendance.manage',


            // Expenses
            'expenses.view',
            'expenses.create',
            'expenses.update',


            // Cash Register
            'cash_register.view',
            'cash_register.open',
            'cash_register.close',
            'cash_register.adjust',


            // Reports
            'reports.view',
            'reports.sales',
            'reports.inventory',
            'reports.financial',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CASHIER
        |--------------------------------------------------------------------------
        */

        $cashier->syncPermissions([

            // Dashboard
            'dashboard.view',


            // Menu
            'menu_items.view',

            'modifiers.view',

            'modifier_options.view',

            'menu_item_modifiers.view',


            // Orders
            'orders.view',
            'orders.create',
            'orders.update',
            'orders.cancel',


            // Order Items
            'order_items.view',
            'order_items.create',
            'order_items.update',
            'order_items.delete',


            // Order Item Modifiers
            'order_item_modifiers.view',
            'order_item_modifiers.create',
            'order_item_modifiers.update',
            'order_item_modifiers.delete',


            // Payments
            'payments.view',
            'payments.create',


            // Customers
            'customers.view',
            'customers.create',
            'customers.update',


            // Cash Register
            'cash_register.view',
            'cash_register.open',
            'cash_register.close',
        ]);


        /*
        |--------------------------------------------------------------------------
        | BARISTA
        |--------------------------------------------------------------------------
        */

        $barista->syncPermissions([

            // Menu
            'menu_items.view',

            'modifiers.view',

            'modifier_options.view',

            'menu_item_modifiers.view',


            // Orders
            'orders.view',
            'orders.update',


            // Order Items
            'order_items.view',
            'order_items.update',


            // Order Item Modifiers
            'order_item_modifiers.view',
        ]);


        /*
        |--------------------------------------------------------------------------
        | EMPLOYEE
        |--------------------------------------------------------------------------
        */

        $employee->syncPermissions([

            // Dashboard
            'dashboard.view',

            // Attendance
            'attendance.view',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Clear Cache Again
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\PermissionRegistrar;

// class RolePermissionSeeder extends Seeder
// {
//     public function run(): void
//     {

//         /*
//         |--------------------------------------------------------------------------
//         | Admin
//         |--------------------------------------------------------------------------
//         */

//         $admin = Role::findByName('admin');

//         $admin->syncPermissions([
//             'dashboard.view',

//             'users.view',
//             'users.create',
//             'users.update',
//             'users.delete',

//             'categories.view',
//             'categories.create',
//             'categories.update',
//             'categories.delete',

//             'menu_items.view',
//             'menu_items.create',
//             'menu_items.update',
//             'menu_items.delete',

//             'modifiers.view',
//             'modifiers.create',
//             'modifiers.update',
//             'modifiers.delete',

//             'recipes.view',
//             'recipes.create',
//             'recipes.update',
//             'recipes.delete',

//             'ingredients.view',
//             'ingredients.create',
//             'ingredients.update',
//             'ingredients.delete',

//             'inventory.view',
//             'inventory.adjust',
//             'inventory.waste',

//             'suppliers.view',
//             'suppliers.create',
//             'suppliers.update',
//             'suppliers.delete',

//             'purchases.view',
//             'purchases.create',
//             'purchases.update',
//             'purchases.receive',
//             'purchases.cancel',

//             'orders.view',
//             'orders.create',
//             'orders.update',
//             'orders.cancel',

//             'payments.view',
//             'payments.create',
//             'payments.refund',

//             'customers.view',
//             'customers.create',
//             'customers.update',
//             'customers.delete',

//             'employees.view',
//             'employees.create',
//             'employees.update',
//             'employees.delete',

//             'attendance.view',
//             'attendance.manage',

//             'expenses.view',
//             'expenses.create',
//             'expenses.update',
//             'expenses.delete',

//             'cash_register.view',
//             'cash_register.open',
//             'cash_register.close',
//             'cash_register.adjust',

//             'reports.view',
//             'reports.sales',
//             'reports.inventory',
//             'reports.financial',

//             'settings.view',
//             'settings.update',
//         ]);


//         /*
//         |--------------------------------------------------------------------------
//         | Manager
//         |--------------------------------------------------------------------------
//         */

//         $manager = Role::findByName('manager');

//         $manager->syncPermissions([
//             'dashboard.view',

//             'categories.view',
//             'categories.create',
//             'categories.update',

//             'menu_items.view',
//             'menu_items.create',
//             'menu_items.update',

//             'modifiers.view',
//             'modifiers.create',
//             'modifiers.update',

//             'recipes.view',
//             'recipes.create',
//             'recipes.update',

//             'ingredients.view',
//             'ingredients.create',
//             'ingredients.update',

//             'inventory.view',
//             'inventory.adjust',
//             'inventory.waste',

//             'suppliers.view',
//             'suppliers.create',
//             'suppliers.update',

//             'purchases.view',
//             'purchases.create',
//             'purchases.update',
//             'purchases.receive',

//             'orders.view',
//             'orders.create',
//             'orders.update',
//             'orders.cancel',

//             'payments.view',
//             'payments.create',
//             'payments.refund',

//             'customers.view',
//             'customers.create',
//             'customers.update',

//             'employees.view',
//             'employees.create',
//             'employees.update',

//             'attendance.view',
//             'attendance.manage',

//             'expenses.view',
//             'expenses.create',
//             'expenses.update',

//             'cash_register.view',
//             'cash_register.open',
//             'cash_register.close',

//             'reports.view',
//             'reports.sales',
//             'reports.inventory',
//             'reports.financial',
//         ]);


//         /*
//         |--------------------------------------------------------------------------
//         | Cashier
//         |--------------------------------------------------------------------------
//         */

//         $cashier = Role::findByName('cashier');

//         $cashier->syncPermissions([
//             'dashboard.view',

//             'menu_items.view',

//             'orders.view',
//             'orders.create',
//             'orders.update',

//             'payments.view',
//             'payments.create',

//             'customers.view',
//             'customers.create',
//             'customers.update',

//             'cash_register.view',
//             'cash_register.open',
//             'cash_register.close',
//         ]);


//         /*
//         |--------------------------------------------------------------------------
//         | Barista
//         |--------------------------------------------------------------------------
//         */

//         $barista = Role::findByName('barista');

//         $barista->syncPermissions([
//             'menu_items.view',

//             'orders.view',
//             'orders.update',
//         ]);


//         /*
//         |--------------------------------------------------------------------------
//         | Employee
//         |--------------------------------------------------------------------------
//         */

//         $employee = Role::findByName('employee');

//         $employee->syncPermissions([
//             'dashboard.view',
//         ]);

//         app()[PermissionRegistrar::class]->forgetCachedPermissions();
//     }
// } -->
