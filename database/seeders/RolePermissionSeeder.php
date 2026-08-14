<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $admin = Role::findByName('admin');

        $admin->syncPermissions([
            'dashboard.view',

            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',

            'menu_items.view',
            'menu_items.create',
            'menu_items.update',
            'menu_items.delete',

            'modifiers.view',
            'modifiers.create',
            'modifiers.update',
            'modifiers.delete',

            'recipes.view',
            'recipes.create',
            'recipes.update',
            'recipes.delete',

            'ingredients.view',
            'ingredients.create',
            'ingredients.update',
            'ingredients.delete',

            'inventory.view',
            'inventory.adjust',
            'inventory.waste',

            'suppliers.view',
            'suppliers.create',
            'suppliers.update',
            'suppliers.delete',

            'purchases.view',
            'purchases.create',
            'purchases.update',
            'purchases.receive',
            'purchases.cancel',

            'orders.view',
            'orders.create',
            'orders.update',
            'orders.cancel',

            'payments.view',
            'payments.create',
            'payments.refund',

            'customers.view',
            'customers.create',
            'customers.update',
            'customers.delete',

            'employees.view',
            'employees.create',
            'employees.update',
            'employees.delete',

            'attendance.view',
            'attendance.manage',

            'expenses.view',
            'expenses.create',
            'expenses.update',
            'expenses.delete',

            'cash_register.view',
            'cash_register.open',
            'cash_register.close',
            'cash_register.adjust',

            'reports.view',
            'reports.sales',
            'reports.inventory',
            'reports.financial',

            'settings.view',
            'settings.update',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */

        $manager = Role::findByName('manager');

        $manager->syncPermissions([
            'dashboard.view',

            'categories.view',
            'categories.create',
            'categories.update',

            'menu_items.view',
            'menu_items.create',
            'menu_items.update',

            'modifiers.view',
            'modifiers.create',
            'modifiers.update',

            'recipes.view',
            'recipes.create',
            'recipes.update',

            'ingredients.view',
            'ingredients.create',
            'ingredients.update',

            'inventory.view',
            'inventory.adjust',
            'inventory.waste',

            'suppliers.view',
            'suppliers.create',
            'suppliers.update',

            'purchases.view',
            'purchases.create',
            'purchases.update',
            'purchases.receive',

            'orders.view',
            'orders.create',
            'orders.update',
            'orders.cancel',

            'payments.view',
            'payments.create',
            'payments.refund',

            'customers.view',
            'customers.create',
            'customers.update',

            'employees.view',
            'employees.create',
            'employees.update',

            'attendance.view',
            'attendance.manage',

            'expenses.view',
            'expenses.create',
            'expenses.update',

            'cash_register.view',
            'cash_register.open',
            'cash_register.close',

            'reports.view',
            'reports.sales',
            'reports.inventory',
            'reports.financial',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Cashier
        |--------------------------------------------------------------------------
        */

        $cashier = Role::findByName('cashier');

        $cashier->syncPermissions([
            'dashboard.view',

            'menu_items.view',

            'orders.view',
            'orders.create',
            'orders.update',

            'payments.view',
            'payments.create',

            'customers.view',
            'customers.create',
            'customers.update',

            'cash_register.view',
            'cash_register.open',
            'cash_register.close',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Barista
        |--------------------------------------------------------------------------
        */

        $barista = Role::findByName('barista');

        $barista->syncPermissions([
            'menu_items.view',

            'orders.view',
            'orders.update',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Employee
        |--------------------------------------------------------------------------
        */

        $employee = Role::findByName('employee');

        $employee->syncPermissions([
            'dashboard.view',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}