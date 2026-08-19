<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


// use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Reset cached permissions
        |--------------------------------------------------------------------------
        */




        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // =========================================================
            // Dashboard
            // =========================================================

            'dashboard.view',


            // =========================================================
            // Users
            // =========================================================

            'users.view',
            'users.create',
            'users.update',
            'users.delete',


            // =========================================================
            // Categories
            // =========================================================

            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',


            // =========================================================
            // Menu Items
            // =========================================================

            'menu_items.view',
            'menu_items.create',
            'menu_items.update',
            'menu_items.delete',


            // =========================================================
            // Modifiers
            // =========================================================

            'modifiers.view',
            'modifiers.create',
            'modifiers.update',
            'modifiers.delete',


            // =========================================================
            // Modifier Options
            // =========================================================

            'modifier_options.view',
            'modifier_options.create',
            'modifier_options.update',
            'modifier_options.delete',


            // =========================================================
            // Menu Item Modifiers
            // =========================================================

            'menu_item_modifiers.view',
            'menu_item_modifiers.create',
            'menu_item_modifiers.update',
            'menu_item_modifiers.delete',


            // =========================================================
            // Recipes
            // =========================================================

            'recipes.view',
            'recipes.create',
            'recipes.update',
            'recipes.delete',


            // =========================================================
            // Recipe Items
            // =========================================================

            'recipe_items.view',
            'recipe_items.create',
            'recipe_items.update',
            'recipe_items.delete',


            // =========================================================
            // Ingredient Categories
            // =========================================================

            'ingredient_categories.view',
            'ingredient_categories.create',
            'ingredient_categories.update',
            'ingredient_categories.delete',


            // =========================================================
            // Ingredients
            // =========================================================

            'ingredients.view',
            'ingredients.create',
            'ingredients.update',
            'ingredients.delete',


            // =========================================================
            // Stock Adjustments
            // =========================================================

            'stock_adjustments.view',
            'stock_adjustments.create',
            'stock_adjustments.update',
            'stock_adjustments.delete',


            // =========================================================
            // Stock Logs
            // =========================================================

            'stock_logs.view',


            // =========================================================
            // Waste Records
            // =========================================================

            'waste_records.view',
            'waste_records.create',
            'waste_records.update',
            'waste_records.delete',


            // =========================================================
            // Inventory
            // =========================================================

            'inventory.view',
            'inventory.adjust',
            'inventory.waste',


            // =========================================================
            // Suppliers
            // =========================================================

            'suppliers.view',
            'suppliers.create',
            'suppliers.update',
            'suppliers.delete',


            // =========================================================
            // Purchases
            // =========================================================

            'purchases.view',
            'purchases.create',
            'purchases.update',
            'purchases.delete',
            'purchases.receive',
            'purchases.cancel',


            // =========================================================
            // Purchase Items
            // =========================================================

            'purchase_items.view',
            'purchase_items.create',
            'purchase_items.update',
            'purchase_items.delete',


            // =========================================================
            // Orders
            // =========================================================

            'orders.view',
            'orders.create',
            'orders.update',
            'orders.cancel',


            // =========================================================
            // Order Items
            // =========================================================

            'order_items.view',
            'order_items.create',
            'order_items.update',
            'order_items.delete',


            // =========================================================
            // Order Item Modifiers
            // =========================================================

            'order_item_modifiers.view',
            'order_item_modifiers.create',
            'order_item_modifiers.update',
            'order_item_modifiers.delete',


            // =========================================================
            // Payments
            // =========================================================

            'payments.view',
            'payments.create',
            'payments.update',
            'payments.delete',
            // 'payments.refund',


            // =========================================================
            // Customers
            // =========================================================

            'customers.view',
            'customers.create',
            'customers.update',
            'customers.delete',


            // =========================================================
            // Employees
            // =========================================================

            'employees.view',
            'employees.create',
            'employees.update',
            'employees.delete',


            // =========================================================
            // Attendance
            // =========================================================

            'attendance.view',
            'attendance.manage',


            // =========================================================
            // Expenses
            // =========================================================

            'expenses.view',
            'expenses.create',
            'expenses.update',
            'expenses.delete',


            // =========================================================
            // Cash Register
            // =========================================================

            'cash_register.view',
            'cash_register.open',
            'cash_register.close',
            'cash_register.adjust',


            // =========================================================
            // Reports
            // =========================================================

            'reports.view',
            'reports.sales',
            'reports.inventory',
            'reports.financial',


            // =========================================================
            // Settings
            // =========================================================

            'settings.view',
            'settings.update',
        ];


        /*
        |--------------------------------------------------------------------------
        | Create Permissions
        |--------------------------------------------------------------------------
        */

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Clear Permission Cache
        |--------------------------------------------------------------------------
        */

      
    }
}


// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\PermissionRegistrar;

// class PermissionSeeder extends Seeder
// {
//     public function run(): void
//     {

//         $permissions = [

//             // Dashboard
//             'dashboard.view',

//             // Categories
//             'categories.view',
//             'categories.create',
//             'categories.update',
//             'categories.delete',

//             // Menu Items
//             'menu_items.view',
//             'menu_items.create',
//             'menu_items.update',
//             'menu_items.delete',

//             // Modifiers
//             'modifiers.view',
//             'modifiers.create',
//             'modifiers.update',
//             'modifiers.delete',

//             // Modifier_Options
//             'modifier_options.view',
//             'modifier_options.create',
//             'modifier_options.update',
//             'modifier_options.delete',

//             // Menu Item Modifiers
//             'menu_item_modifiers.view',
//             'menu_item_modifiers.create',
//             'menu_item_modifiers.update',
//             'menu_item_modifiers.delete',

//             // Recipes
//             'recipes.view',
//             'recipes.create',
//             'recipes.update',
//             'recipes.delete',

//             // Recipe Items
//             'recipe_items.view',
//             'recipe_items.create',
//             'recipe_items.update',
//             'recipe_items.delete',

//             // Ingredient Categories
//             'ingredient_categories.view',
//             'ingredient_categories.create',
//             'ingredient_categories.update',
//             'ingredient_categories.delete',

//             // Ingredients
//             'ingredients.view',
//             'ingredients.create',
//             'ingredients.update',
//             'ingredients.delete',

//             // Stock Adjustments
//             'stock_adjustments.view',
//             'stock_adjustments.create',
//             'stock_adjustments.delete',
//             'stock_adjustments.update',

//             // Stock Logs
//             'stock_logs.view',
            
//             // Waste Records
//             'waste_records.view',
//             'waste_records.create',
//             'waste_records.delete',
//             'waste_records.update',

//             // Inventory
//             'inventory.view',
//             'inventory.adjust',
//             'inventory.waste',

//             // Suppliers
//             'suppliers.view',
//             'suppliers.create',
//             'suppliers.update',
//             'suppliers.delete',

//             // Purchases
//             'purchases.view',
//             'purchases.create',
//             'purchases.update',
//             'purchase.delete',
            

//             // PurchaseItems
//             'purchase_items.view',
//             'purchase_items.create',
//             'purchase_items.update',
//             'purchase_items.delete',
            

//             // Orders
//             'orders.view',
//             'orders.create',
//             'orders.update',
//             'orders.cancel',

//             // OrderItems
//             'order_items.view',
//             'order_items.create',
//             'order_items.update',
//             'order_items.delete',

//             // Order_Item_Modifier
//             'order_item_modifiers.view',
//             'order_item_modifiers.create',
//             'order_item_modifiers.update',
//             'order_item_modifiers.delete',

//             // Payments
//             'payments.view',
//             'payments.create',
//             'payments.update',
//             'payments.delete',
//             // 'payments.refund',

//             // Customers
//             'customers.view',
//             'customers.create',
//             'customers.update',
//             'customers.delete',

//             // Employees
//             'employees.view',
//             'employees.create',
//             'employees.update',
//             'employees.delete',

//             // Attendance
//             'attendance.view',
//             'attendance.manage',

//             // Expenses
//             'expenses.view',
//             'expenses.create',
//             'expenses.update',
//             'expenses.delete',

//             // Cash Register
//             'cash_register.view',
//             'cash_register.open',
//             'cash_register.close',
//             'cash_register.adjust',

//             // Reports
//             'reports.view',
//             'reports.sales',
//             'reports.inventory',
//             'reports.financial',

//             // Settings
//             'settings.view',
//             'settings.update',
//         ];

//         foreach ($permissions as $permission) {
//             Permission::firstOrCreate([
//                 'name' => $permission,
//                 'guard_name' => 'web',
//             ]);
//         }
//     }
// } -->
