<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\CreateRolesRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Commands\CreateRole;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index(Request $request){
        $columns = array_keys(__('db.roles'));
        $data = Role::paginate(Helper::PerPage())->withQueryString();
        return view('roles.index', compact('data', 'columns'));
    }


    public function show($id){
        $role = \App\Models\Role::find($id);
        if (!$role){
            abort(404);
        }
        $role_has_permissions = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::get()->groupBy('group_name');
        return view('roles.show', compact('role', 'role_has_permissions', 'permissions'));
    }

    public function create(Request $request)
    {
        $permissions = Permission::get()->groupBy('group_name');
        return view('roles.create', compact('permissions'));
    }

    public function edit($id, Request $request)
    {
        $role = \App\Models\Role::find($id);
        if (!$role){
            abort(404);
        }
        $role_has_permissions = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::get()->groupBy('group_name');
        return view('roles.edit', compact('permissions', 'role_has_permissions', 'role'));
    }


    public function store(CreateRolesRequest $request)
    {
        DB::beginTransaction();
        try {
            $data =  $request->validated();
            $role_name = Str::slug($data['role_name']['en']);
            $has_role = \App\Models\Role::where('name', $role_name)->count();
            if($has_role){
                throw new \Exception('already exists');
            }

            $role = \App\Models\Role::create([
                'name' => $role_name,
                'display_name' => $data['role_name']
            ]);

            Permission::whereIn('id', $data['permission_id'])->get()->each(function ($permission) use($role){
                $role->givePermissionTo($permission);
                $permission->assignRole($role);
            });
            DB::commit();
            return $this->successMessage(Helper::CreatedSuccessFully());
        }
        catch (\Exception $exception){
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }

    public function update($id, CreateRolesRequest $request){
        $role = \App\Models\Role::find($id);
        if (!$role){
            abort(404);
        }

        DB::beginTransaction();
        try {
            $data =  $request->validated();
            $role_name = Str::slug($data['role_name']['en']);

            $role->update([
                'name' => $role_name,
                'display_name' => $data['role_name']
            ]);

            $permissions = Permission::whereIn('id', $data['permission_id'])->get();
            $role->syncPermissions($permissions);
            DB::commit();
            return $this->successMessage(Helper::UpdatedSuccessFully());
        }
        catch (\Exception $exception){
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }



    }

    public function delete($id){
        $role = \App\Models\Role::find($id);
        if (!$role){
            abort(404);
        }

        $role->delete();
        return $this->successMessage(Helper::DeletedSuccessFully());
    }
}
