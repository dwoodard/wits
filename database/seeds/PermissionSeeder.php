<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Should have a permission for every Model and its function.
        Permission::create([ 'name' => 'asset.index', 'label'=>'asset.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'asset.store', 'label'=>'asset.store', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'asset.destroy', 'label'=>'asset.destroy', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'asset.update', 'label'=>'asset.update', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'asset.show', 'label'=>'asset.show', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'asset.add-media', 'label'=>'asset.add-media', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'asset.delete-media', 'label'=>'asset.delete-media', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'buildings.index', 'label'=>'buildings.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'buildings.store', 'label'=>'buildings.store', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'buildings.update', 'label'=>'buildings.update', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'buildings.show', 'label'=>'buildings.show', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'buildings.destroy', 'label'=>'buildings.destroy', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'campus.store', 'label'=>'campus.store', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'campus.index', 'label'=>'campus.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'campus.show', 'label'=>'campus.show', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'campus.update', 'label'=>'campus.update', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'campus.destroy', 'label'=>'campus.destroy', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'category.index', 'label'=>'category.index', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'user.currentuser', 'label'=>'user.currentuser', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'departments.store', 'label'=>'departments.store', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'departments.index', 'label'=>'departments.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'departments.show', 'label'=>'departments.show', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'departments.update', 'label'=>'departments.update', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'departments.destroy', 'label'=>'departments.destroy', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'permissions.index', 'label'=>'permissions.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'permissions.show', 'label'=>'permissions.show', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'properties.index', 'label'=>'properties.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'properties.store', 'label'=>'properties.store', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'properties.destroy', 'label'=>'properties.destroy', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'roles.index', 'label'=>'roles.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'roles.show', 'label'=>'roles.show', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'roles.sync.permission', 'label'=>'roles.sync.permission', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'rooms.store', 'label'=>'rooms.store', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'rooms.index', 'label'=>'rooms.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'rooms.update', 'label'=>'rooms.update', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'rooms.destroy', 'label'=>'rooms.destroy', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'rooms.sync.departments', 'label'=>'rooms.sync.departments', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'rooms.sync.supports', 'label'=>'rooms.sync.supports', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'roomstyle.store', 'label'=>'roomstyle.store', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'roomstyle.index', 'label'=>'roomstyle.index', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'rooms.add-media', 'label'=>'rooms.add-media', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'rooms.delete-media', 'label'=>'rooms.delete-media', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'software.store', 'label'=>'software.store', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'software.index', 'label'=>'software.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'software.destroy', 'label'=>'software.destroy', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'software.show', 'label'=>'software.show', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'software.update', 'label'=>'software.update', 'guard_name' => 'web']);

        Permission::create([ 'name' => 'transfer.store', 'label'=>'transfer.store', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'transfer.index', 'label'=>'transfer.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'transfer.destroy', 'label'=>'transfer.destroy', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'transfer.show', 'label'=>'transfer.show', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'transfer.update', 'label'=>'transfer.update', 'guard_name' => 'web']);


        Permission::create([ 'name' => 'users.index', 'label'=>'users.index', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'users.store', 'label'=>'users.store', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'users.show', 'label'=>'users.show', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'users.update', 'label'=>'users.update', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'users.destroy', 'label'=>'users.destroy', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'users.sync.departments', 'label'=>'users.sync.departments', 'guard_name' => 'web']);
        Permission::create([ 'name' => 'users.sync.roles', 'label'=>'users.sync.roles', 'guard_name' => 'web']);



        // create roles and assign existing permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo('asset.index');
        $role->givePermissionTo('asset.store');
        $role->givePermissionTo('asset.destroy');
        $role->givePermissionTo('asset.update');
        $role->givePermissionTo('asset.show');
        $role->givePermissionTo('asset.add-media');
        $role->givePermissionTo('asset.delete-media');
        $role->givePermissionTo('buildings.index');
        $role->givePermissionTo('buildings.store');
        $role->givePermissionTo('buildings.update');
        $role->givePermissionTo('buildings.show');
        $role->givePermissionTo('buildings.destroy');
        $role->givePermissionTo('campus.store');
        $role->givePermissionTo('campus.index');
        $role->givePermissionTo('campus.show');
        $role->givePermissionTo('campus.update');
        $role->givePermissionTo('campus.destroy');
        $role->givePermissionTo('category.index');
        $role->givePermissionTo('user.currentuser');
        $role->givePermissionTo('departments.store');
        $role->givePermissionTo('departments.index');
        $role->givePermissionTo('departments.show');
        $role->givePermissionTo('departments.update');
        $role->givePermissionTo('departments.destroy');
        $role->givePermissionTo('permissions.index');
        $role->givePermissionTo('permissions.show');
        $role->givePermissionTo('properties.index');
        $role->givePermissionTo('properties.store');
        $role->givePermissionTo('properties.destroy');
        $role->givePermissionTo('roles.index');
        $role->givePermissionTo('roles.show');
        $role->givePermissionTo('roles.sync.permission');
        $role->givePermissionTo('rooms.store');
        $role->givePermissionTo('rooms.index');
        $role->givePermissionTo('rooms.update');
        $role->givePermissionTo('rooms.destroy');
        $role->givePermissionTo('rooms.sync.departments');
        $role->givePermissionTo('rooms.add-media');
        $role->givePermissionTo('rooms.delete-media');
        $role->givePermissionTo('rooms.sync.supports');
        $role->givePermissionTo('roomstyle.store');
        $role->givePermissionTo('roomstyle.index');
        $role->givePermissionTo('software.store');
        $role->givePermissionTo('software.index');
        $role->givePermissionTo('software.destroy');
        $role->givePermissionTo('software.show');
        $role->givePermissionTo('software.update');
        $role->givePermissionTo('transfer.store');
        $role->givePermissionTo('transfer.index');
        $role->givePermissionTo('transfer.destroy');
        $role->givePermissionTo('transfer.show');
        $role->givePermissionTo('transfer.update');
        $role->givePermissionTo('users.index');
        $role->givePermissionTo('users.store');
        $role->givePermissionTo('users.show');
        $role->givePermissionTo('users.update');
        $role->givePermissionTo('users.destroy');
        $role->givePermissionTo('users.sync.departments');
        $role->givePermissionTo('users.sync.roles');









        // Roles
        // $admin = Role::create(['name' => 'admin']);
        // $admin->givePermissionTo(['create_asset', 'read_asset', 'update_asset', 'delete_asset']);
        //See all can do all

        $role = Role::create(['name' => 'user']);
        // see only locations and inventory from location
        $role->givePermissionTo('asset.index');
        // $role->givePermissionTo('asset.store');
        // $role->givePermissionTo('asset.destroy');
        // $role->givePermissionTo('asset.update');
        $role->givePermissionTo('asset.show');
        // $role->givePermissionTo('asset.add-media');
        // $role->givePermissionTo('asset.delete-media');
        $role->givePermissionTo('buildings.index');
        // $role->givePermissionTo('buildings.store');
        // $role->givePermissionTo('buildings.update');
        $role->givePermissionTo('buildings.show');
        // $role->givePermissionTo('buildings.destroy');
        // $role->givePermissionTo('campus.store');
        $role->givePermissionTo('campus.index');
        $role->givePermissionTo('campus.show');
        // $role->givePermissionTo('campus.update');
        // $role->givePermissionTo('campus.destroy');
        $role->givePermissionTo('category.index');
        $role->givePermissionTo('user.currentuser');
        // $role->givePermissionTo('departments.store');
        $role->givePermissionTo('departments.index');
        $role->givePermissionTo('departments.show');
        // $role->givePermissionTo('departments.update');
        // $role->givePermissionTo('departments.destroy');
        $role->givePermissionTo('permissions.index');
        $role->givePermissionTo('permissions.show');
        $role->givePermissionTo('properties.index');
        // $role->givePermissionTo('properties.store');
        // $role->givePermissionTo('properties.destroy');
        $role->givePermissionTo('roles.index');
        $role->givePermissionTo('roles.show');
        // $role->givePermissionTo('roles.sync.permission');
        // $role->givePermissionTo('rooms.store');
        $role->givePermissionTo('rooms.index');
        // $role->givePermissionTo('rooms.update');
        // $role->givePermissionTo('rooms.destroy');
        // $role->givePermissionTo('rooms.sync.departments');
        // $role->givePermissionTo('rooms.add-media');
        // $role->givePermissionTo('rooms.delete-media');
        // $role->givePermissionTo('rooms.sync.supports');
        // $role->givePermissionTo('roomstyle.store');
        $role->givePermissionTo('roomstyle.index');
        // $role->givePermissionTo('software.store');
        // $role->givePermissionTo('software.index');
        // $role->givePermissionTo('software.destroy');
        // $role->givePermissionTo('software.show');
        // $role->givePermissionTo('software.update');
        // $role->givePermissionTo('transfer.store');
        // $role->givePermissionTo('transfer.index');
        // $role->givePermissionTo('transfer.destroy');
        // $role->givePermissionTo('transfer.show');
        // $role->givePermissionTo('transfer.update');
        // $role->givePermissionTo('users.index');
        // $role->givePermissionTo('users.show');
        // $role->givePermissionTo('users.update');
        // $role->givePermissionTo('users.destroy');
        // $role->givePermissionTo('users.sync.departments');
        // $role->givePermissionTo('users.sync.roles');



        $role = Role::create(['name' => 'department_admin']);
        // can see their department and below
        $role->givePermissionTo('asset.index');
        $role->givePermissionTo('asset.store');
        $role->givePermissionTo('asset.destroy');
        $role->givePermissionTo('asset.update');
        $role->givePermissionTo('asset.show');
        $role->givePermissionTo('asset.add-media');
        $role->givePermissionTo('asset.delete-media');
        $role->givePermissionTo('buildings.index');
        $role->givePermissionTo('buildings.store');
        $role->givePermissionTo('buildings.update');
        $role->givePermissionTo('buildings.show');
        $role->givePermissionTo('buildings.destroy');
        $role->givePermissionTo('campus.store');
        $role->givePermissionTo('campus.index');
        $role->givePermissionTo('campus.show');
        $role->givePermissionTo('campus.update');
        $role->givePermissionTo('campus.destroy');
        $role->givePermissionTo('category.index');
        $role->givePermissionTo('user.currentuser');
        $role->givePermissionTo('departments.store');
        $role->givePermissionTo('departments.index');
        $role->givePermissionTo('departments.show');
        $role->givePermissionTo('departments.update');
        $role->givePermissionTo('departments.destroy');
        // $role->givePermissionTo('permissions.index');
        // $role->givePermissionTo('permissions.show');
        $role->givePermissionTo('properties.index');
        $role->givePermissionTo('properties.store');
        $role->givePermissionTo('properties.destroy');
        $role->givePermissionTo('roles.index');
        $role->givePermissionTo('roles.show');
        $role->givePermissionTo('roles.sync.permission');
        $role->givePermissionTo('rooms.store');
        $role->givePermissionTo('rooms.index');
        $role->givePermissionTo('rooms.update');
        $role->givePermissionTo('rooms.destroy');
        $role->givePermissionTo('rooms.sync.departments');
        $role->givePermissionTo('rooms.add-media');
        $role->givePermissionTo('rooms.delete-media');
        $role->givePermissionTo('rooms.sync.supports');
        $role->givePermissionTo('roomstyle.store');
        $role->givePermissionTo('roomstyle.index');
        $role->givePermissionTo('software.store');
        $role->givePermissionTo('software.index');
        $role->givePermissionTo('software.destroy');
        $role->givePermissionTo('software.show');
        $role->givePermissionTo('software.update');
        $role->givePermissionTo('transfer.store');
        $role->givePermissionTo('transfer.index');
        $role->givePermissionTo('transfer.destroy');
        $role->givePermissionTo('transfer.show');
        $role->givePermissionTo('transfer.update');
        $role->givePermissionTo('users.index');
        $role->givePermissionTo('users.show');
        $role->givePermissionTo('users.store');
        $role->givePermissionTo('users.update');
        $role->givePermissionTo('users.destroy');
        $role->givePermissionTo('users.sync.departments');
        $role->givePermissionTo('users.sync.roles');


        $role = Role::create(['name' => 'department_user']);
        // see only department
        $role->givePermissionTo('asset.index');
        $role->givePermissionTo('asset.store');
        $role->givePermissionTo('asset.destroy');
        $role->givePermissionTo('asset.update');
        $role->givePermissionTo('asset.show');
        $role->givePermissionTo('asset.add-media');
        $role->givePermissionTo('asset.delete-media');
        $role->givePermissionTo('buildings.index');
        $role->givePermissionTo('buildings.store');
        $role->givePermissionTo('buildings.update');
        $role->givePermissionTo('buildings.show');
        // $role->givePermissionTo('buildings.destroy');
        $role->givePermissionTo('campus.store');
        $role->givePermissionTo('campus.index');
        $role->givePermissionTo('campus.show');
        $role->givePermissionTo('campus.update');
        // $role->givePermissionTo('campus.destroy');
        $role->givePermissionTo('category.index');
        $role->givePermissionTo('user.currentuser');
        $role->givePermissionTo('departments.store');
        $role->givePermissionTo('departments.index');
        $role->givePermissionTo('departments.show');
        $role->givePermissionTo('departments.update');
        $role->givePermissionTo('departments.destroy');
        // $role->givePermissionTo('permissions.index');
        // $role->givePermissionTo('permissions.show');
        $role->givePermissionTo('properties.index');
        $role->givePermissionTo('properties.store');
        $role->givePermissionTo('properties.destroy');
        $role->givePermissionTo('roles.index');
        $role->givePermissionTo('roles.show');
        // $role->givePermissionTo('roles.sync.permission');
        $role->givePermissionTo('rooms.store');
        $role->givePermissionTo('rooms.index');
        $role->givePermissionTo('rooms.update');
        // $role->givePermissionTo('rooms.destroy');
        $role->givePermissionTo('rooms.sync.departments');
        $role->givePermissionTo('rooms.add-media');
        $role->givePermissionTo('rooms.delete-media');
        $role->givePermissionTo('rooms.sync.supports');
        $role->givePermissionTo('roomstyle.store');
        $role->givePermissionTo('roomstyle.index');
        $role->givePermissionTo('software.store');
        $role->givePermissionTo('software.index');
        $role->givePermissionTo('software.destroy');
        $role->givePermissionTo('software.show');
        $role->givePermissionTo('software.update');
        // $role->givePermissionTo('transfer.store');
        // $role->givePermissionTo('transfer.index');
        // $role->givePermissionTo('transfer.destroy');
        // $role->givePermissionTo('transfer.show');
        // $role->givePermissionTo('transfer.update');
        $role->givePermissionTo('users.index');
        $role->givePermissionTo('users.show');
        // $role->givePermissionTo('users.update');
        // $role->givePermissionTo('users.destroy');
        // $role->givePermissionTo('users.sync.departments');
        // $role->givePermissionTo('users.sync.roles');

        $role = Role::create(['name' => 'auditor']);
        // can see assets all assets
        $role->givePermissionTo('asset.index');
        // $role->givePermissionTo('asset.store');
        // $role->givePermissionTo('asset.destroy');
        $role->givePermissionTo('asset.update');
        $role->givePermissionTo('asset.show');
        // $role->givePermissionTo('asset.add-media');
        // $role->givePermissionTo('asset.delete-media');
        $role->givePermissionTo('buildings.index');
        // $role->givePermissionTo('buildings.store');
        // $role->givePermissionTo('buildings.update');
        $role->givePermissionTo('buildings.show');
        // $role->givePermissionTo('buildings.destroy');
        $role->givePermissionTo('campus.index');
        // $role->givePermissionTo('campus.store');
        $role->givePermissionTo('campus.show');
        // $role->givePermissionTo('campus.update');
        // $role->givePermissionTo('campus.destroy');
        $role->givePermissionTo('category.index');
        $role->givePermissionTo('user.currentuser');
        // $role->givePermissionTo('departments.store');
        $role->givePermissionTo('departments.index');
        $role->givePermissionTo('departments.show');
        // $role->givePermissionTo('departments.update');
        // $role->givePermissionTo('departments.destroy');
        // $role->givePermissionTo('permissions.index');
        // $role->givePermissionTo('permissions.show');
        $role->givePermissionTo('properties.index');
        // $role->givePermissionTo('properties.store');
        // $role->givePermissionTo('properties.destroy');
        $role->givePermissionTo('roles.index');
        $role->givePermissionTo('roles.show');
        // $role->givePermissionTo('roles.sync.permission');
        // $role->givePermissionTo('rooms.store');
        $role->givePermissionTo('rooms.index');
        $role->givePermissionTo('rooms.update');
        // $role->givePermissionTo('rooms.destroy');
        // $role->givePermissionTo('rooms.sync.departments');
        // $role->givePermissionTo('rooms.add-media');
        // $role->givePermissionTo('rooms.delete-media');
        // $role->givePermissionTo('rooms.sync.supports');
        // $role->givePermissionTo('roomstyle.store');
        $role->givePermissionTo('roomstyle.index');
        // $role->givePermissionTo('software.store');
        // $role->givePermissionTo('software.index');
        // $role->givePermissionTo('software.destroy');
        // $role->givePermissionTo('software.show');
        // $role->givePermissionTo('software.update');
        // $role->givePermissionTo('transfer.store');
        // $role->givePermissionTo('transfer.index');
        // $role->givePermissionTo('transfer.destroy');
        // $role->givePermissionTo('transfer.show');
        // $role->givePermissionTo('transfer.update');
        $role->givePermissionTo('users.index');
        $role->givePermissionTo('users.show');
        // $role->givePermissionTo('users.update');
        // $role->givePermissionTo('users.destroy');
        // $role->givePermissionTo('users.sync.departments');
        // $role->givePermissionTo('users.sync.roles');


        $role = Role::create(['name' => 'financial']);
        // can see all assets and suggest changes
        $role->givePermissionTo('asset.index');
        // $role->givePermissionTo('asset.store');
        // $role->givePermissionTo('asset.destroy');
        $role->givePermissionTo('asset.update');
        $role->givePermissionTo('asset.show');
        // $role->givePermissionTo('asset.add-media');
        // $role->givePermissionTo('asset.delete-media');
        $role->givePermissionTo('buildings.index');
        // $role->givePermissionTo('buildings.store');
        // $role->givePermissionTo('buildings.update');
        $role->givePermissionTo('buildings.show');
        // $role->givePermissionTo('buildings.destroy');
        $role->givePermissionTo('campus.index');
        // $role->givePermissionTo('campus.store');
        $role->givePermissionTo('campus.show');
        // $role->givePermissionTo('campus.update');
        // $role->givePermissionTo('campus.destroy');
        $role->givePermissionTo('category.index');
        $role->givePermissionTo('user.currentuser');
        // $role->givePermissionTo('departments.store');
        $role->givePermissionTo('departments.index');
        $role->givePermissionTo('departments.show');
        // $role->givePermissionTo('departments.update');
        // $role->givePermissionTo('departments.destroy');
        // $role->givePermissionTo('permissions.index');
        // $role->givePermissionTo('permissions.show');
        $role->givePermissionTo('properties.index');
        // $role->givePermissionTo('properties.store');
        // $role->givePermissionTo('properties.destroy');
        $role->givePermissionTo('roles.index');
        $role->givePermissionTo('roles.show');
        // $role->givePermissionTo('roles.sync.permission');
        // $role->givePermissionTo('rooms.store');
        $role->givePermissionTo('rooms.index');
        $role->givePermissionTo('rooms.update');
        // $role->givePermissionTo('rooms.destroy');
        // $role->givePermissionTo('rooms.sync.departments');
        // $role->givePermissionTo('rooms.add-media');
        // $role->givePermissionTo('rooms.delete-media');
        // $role->givePermissionTo('rooms.sync.supports');
        // $role->givePermissionTo('roomstyle.store');
        $role->givePermissionTo('roomstyle.index');
        // $role->givePermissionTo('software.store');
        // $role->givePermissionTo('software.index');
        // $role->givePermissionTo('software.destroy');
        // $role->givePermissionTo('software.show');
        // $role->givePermissionTo('software.update');
        // $role->givePermissionTo('transfer.store');
        // $role->givePermissionTo('transfer.index');
        // $role->givePermissionTo('transfer.destroy');
        // $role->givePermissionTo('transfer.show');
        // $role->givePermissionTo('transfer.update');
        $role->givePermissionTo('users.index');
        $role->givePermissionTo('users.show');
        // $role->givePermissionTo('users.update');
        // $role->givePermissionTo('users.destroy');
        // $role->givePermissionTo('users.sync.departments');
        // $role->givePermissionTo('users.sync.roles');

        $role = Role::create(['name' => 'room_support']);
        // Supports Rooms
        $role->givePermissionTo('asset.index');
        // $role->givePermissionTo('asset.store');
        // $role->givePermissionTo('asset.destroy');
        // $role->givePermissionTo('asset.update');
        $role->givePermissionTo('asset.show');
        // $role->givePermissionTo('asset.add-media');
        // $role->givePermissionTo('asset.delete-media');
        $role->givePermissionTo('buildings.index');
        $role->givePermissionTo('buildings.store');
        $role->givePermissionTo('buildings.update');
        $role->givePermissionTo('buildings.show');
        // $role->givePermissionTo('buildings.destroy');
        $role->givePermissionTo('campus.store');
        $role->givePermissionTo('campus.index');
        $role->givePermissionTo('campus.show');
        $role->givePermissionTo('campus.update');
        // $role->givePermissionTo('campus.destroy');
        $role->givePermissionTo('category.index');
        $role->givePermissionTo('user.currentuser');
        // $role->givePermissionTo('departments.store');
        $role->givePermissionTo('departments.index');
        $role->givePermissionTo('departments.show');
        // $role->givePermissionTo('departments.update');
        // $role->givePermissionTo('departments.destroy');
        $role->givePermissionTo('permissions.index');
        $role->givePermissionTo('permissions.show');
        $role->givePermissionTo('properties.index');
        $role->givePermissionTo('properties.store');
        // $role->givePermissionTo('properties.destroy');
        $role->givePermissionTo('roles.index');
        $role->givePermissionTo('roles.show');
        // $role->givePermissionTo('roles.sync.permission');
        // $role->givePermissionTo('rooms.store');
        $role->givePermissionTo('rooms.index');
        $role->givePermissionTo('rooms.update');
        $role->givePermissionTo('rooms.destroy');
        $role->givePermissionTo('rooms.sync.departments');
        $role->givePermissionTo('rooms.add-media');
        $role->givePermissionTo('rooms.delete-media');
        // $role->givePermissionTo('rooms.sync.supports');
        // $role->givePermissionTo('roomstyle.store');
        $role->givePermissionTo('roomstyle.index');
        $role->givePermissionTo('software.store');
        $role->givePermissionTo('software.index');
        $role->givePermissionTo('software.destroy');
        $role->givePermissionTo('software.show');
        $role->givePermissionTo('software.update');
        // $role->givePermissionTo('transfer.store');
        // $role->givePermissionTo('transfer.index');
        // $role->givePermissionTo('transfer.destroy');
        // $role->givePermissionTo('transfer.show');
        // $role->givePermissionTo('transfer.update');
        // $role->givePermissionTo('users.index');
        // $role->givePermissionTo('users.show');
        // $role->givePermissionTo('users.update');
        // $role->givePermissionTo('users.destroy');
        // $role->givePermissionTo('users.sync.departments');
        // $role->givePermissionTo('users.sync.roles');
    }




}
