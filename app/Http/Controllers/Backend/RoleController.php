<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // ================== Permission Methods ==================

    public function AllPermission() {
        $permissions = Permission::all();
        return view('backend.pages.permission.all_permission', compact('permissions'));
    }

    public function AddPermission() {
        return view('backend.pages.permission.add_permission');
    }

    public function StorePermission(Request $request) {
        // Standard Validation
        $request->validate([
            'name' => 'required',
            'group_name' => 'required',
        ]);
    
        // Manual Duplicate Check
        $exists = Permission::where('name', $request->name)
                            ->where('guard_name', 'web')
                            ->first();
    
        if ($exists) {
            // This is the key: manually adding to the Error Bag
            return redirect()->back()
                ->withErrors(['name' => 'The permission "' . $request->name . '" already exists.'])
                ->withInput();
        }
    
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
            'guard_name' => 'web',
        ]);
    
        $notification = array(
            'message' => 'Permission Added Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->route('all.permission')->with($notification);
    }

    public function EditPermission($id) {
        $permission = Permission::findOrFail($id);
        return view('backend.pages.permission.edit_permission', compact('permission'));
    }

    public function UpdatePermission(Request $request){
        $per_id = $request->id;
    
        // 1. Validate basic requirements
        $request->validate([
            'name' => 'required|max:200',
            'group_name' => 'required',
        ]);
    
        // 2. Check for duplicates (Exclude the current ID)
        $exists = Permission::where('name', $request->name)
                            ->where('guard_name', 'web')
                            ->where('id', '!=', $per_id) // Don't count the current record
                            ->first();
    
        if ($exists) {
            return redirect()->back()
                ->withErrors(['name' => 'The permission name "' . $request->name . '" is already taken for the web guard.'])
                ->withInput();
        }
    
        // 3. Update if check passes
        Permission::findOrFail($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);
    
        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->route('all.permission')->with($notification);
    }

    public function DeletePermission($id) {
        Permission::findOrFail($id)->delete();
        return redirect()->back()->with([
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    // ================== Role Methods ==================

    public function AllRoles() {
        $roles = Role::all();
        return view('backend.pages.roles.all_roles', compact('roles'));
    }

    public function AddRoles() {
        return view('backend.pages.roles.add_roles');
    }

    public function StoreRoles(Request $request) {
        Role::create(['name' => $request->name]);

        return redirect()->route('all.roles')->with([
            'message' => 'Role Added Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function EditRoles($id) {
        $roles = Role::findOrFail($id);
        return view('backend.pages.roles.edit_roles', compact('roles'));
    }

    public function UpdateRoles(Request $request){
        $role_id = $request->id;
    
        // 1. Basic Validation
        $request->validate([
            'name' => 'required|max:200',
        ]);
    
        // 2. Duplicate Check (Exclude current ID)
        $exists = Role::where('name', $request->name)
                      ->where('guard_name', 'web')
                      ->where('id', '!=', $role_id)
                      ->first();
    
        if ($exists) {
            return redirect()->back()
                ->withErrors(['name' => 'The Role "' . $request->name . '" already exists.'])
                ->withInput();
        }
    
        // 3. Update
        Role::findOrFail($role_id)->update([
            'name' => $request->name, 
        ]);
    
        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->route('all.roles')->with($notification);
    }

    public function DeleteRoles($id) {
        Role::findOrFail($id)->delete();
        return redirect()->back()->with([
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    // ================== Role + Permission Assignment ==================

    public function AddRolesPermission() {
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.roles.add_roles_permission', compact('roles', 'permissions', 'permission_groups'));
    }

    /**
     * Enhanced Store Method using Spatie syncPermissions
     */
    public function StoreRolesPermission(Request $request) {
        $role = Role::findOrFail($request->role_id);
        $permissions = $request->permission; // Array of IDs

        if (!empty($permissions)) {
            // Convert IDs to Names (Spatie sync works best with names)
            $permissionNames = Permission::whereIn('id', $permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        }

        return redirect()->route('all.roles.permission')->with([
            'message' => 'Role Permissions Assigned Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function AllRolesPermission() {
        $roles = Role::all();
        return view('backend.pages.roles.all_roles_permission', compact('roles'));
    }

    public function AdminEditRoles($id) {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.roles.edit_roles_permission', compact('role', 'permissions', 'permission_groups')); 
    }

    public function RolePermissionUpdate(Request $request, $id) {
        $role = Role::findOrFail($id);
        $permissions = $request->permission;

        // If no permissions are selected, we should clear all permissions
        if (!empty($permissions)) {
            $permissionNames = Permission::whereIn('id', $permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        } else {
            $role->syncPermissions([]); // Revoke all if empty
        }

        return redirect()->route('all.roles.permission')->with([
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function AdminDeleteRoles($id) {
        $role = Role::findOrFail($id);
        if (!is_null($role)) {
            $role->delete();
        }

        return redirect()->back()->with([
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }
}