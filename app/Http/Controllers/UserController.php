<?php

namespace App\Http\Controllers;

use App\Enums\ExportFormat;
use App\Enums\UserTypeEnum;
use App\Helper;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\Invoice\InvoiceCreateRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\CompanySetting;
use App\Models\Invoice;
use App\Models\InvoiceData;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function profilePage(){
        return view('users.profile');
    }

    public function updateProfile(UpdateProfileRequest $request){
        $user = auth()->user();
        $data = collect($request->validated())->except('file')->toArray();
        try {
            if ($request->file){
                $user->clearMediaCollection();
                $user->addMediaFromRequest('file')->toMediaCollection();
            }
            $user->update($data);
            return $this->successMessage(Helper::UpdatedSuccessFully());
        }
        catch (\Exception $exception){
            return $this->errorMessage($exception->getMessage());
        }
    }

    public function changePasswordPage(){
        return view('users.change_password');
    }
    public function changePassword(ChangePasswordRequest $request){
        if (Hash::check($request->old_password, auth()->user()->password)){
            $new_password = Hash::make($request->new_password);
            auth()->user()->update(['password' => $new_password]);
            return $this->successMessage(Helper::UpdatedSuccessFully());
        }
        else{
            return $this->errorMessage(__('page.your_old_password_did_not_match'));
        }
    }

    public function index(Request $request){
        $columns = array_keys(__('db.users'));
        $data = User::filter()->paginate(Helper::PerPage())->withQueryString();
//        $permissions =  $data->first()->roles->flatMap->permissions->pluck('name');
        return view('users.index', compact('data', 'columns'));
    }

    public function show($id){
        $user =  User::find($id);
        if (!$user){
            abort(404);
        }
        $user = User::find($id);
        $permissions =  $user->getAllPermissions()->groupBy('group_name');
        return view('users.show', compact('user', 'permissions'));
    }

    public function create(Request $request)
    {
        $roles = Role::get();
        //calculation end
        return view('users.create', compact( 'roles'));
    }

    public function edit($id, Request $request)
    {
        $roles = Role::get();
        $user = User::find($id);
        $user_role_id = $user->roles?->first()?->id;
        if (!$user){
            abort(404, 'not fond');
        }

        return view('users.edit', compact('user', 'roles', 'user_role_id'));
    }


    public function store(UserCreateRequest $request){
        $data = collect($request->validated());
        $data['password'] = Hash::make($data['password']);
        DB::beginTransaction();
        try {
            $role = Role::find($request->role_id);
            $user =  User::create($data->except('role_id')->toArray());
            $user->assignRole($role);
            DB::commit();
            return redirect()->route('user.index')->with('success', Helper::CreatedSuccessFully());
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage())->withInput($request->all());
        }
    }


    public function update($id, UserUpdateRequest $request){
        $data = collect($request->validated())->filter();
        if ($data->has('password')){
            $data['password'] = Hash::make($data['password']);
        }

        DB::beginTransaction();
        $user = User::find($id);
        if (!$user){
            abort(404, 'not fond');
        }
        try {
            $role = Role::find($request->role_id);
            $user->update($data->except('role_id')->toArray());
            $user->syncRoles($role);
            DB::commit();
            return $this->successMessage(Helper::UpdatedSuccessFully());
        }
        catch (\Exception $exception){
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }


    public function delete($id){
        $user =  User::find($id);
        if (!$user){
            abort(404);
        }
        if ($user->user_type == UserTypeEnum::SYSTEM->value){
            return $this->errorMessage('Can not delete. because this user is for system');
        }

        $user->delete();
        return $this->successMessage(Helper::DeletedSuccessFully());
    }

    public function changeStatus($id){
        $invoice =  Invoice::find($id);
        if (!$invoice){
            abort(404);
        }

        $invoice->is_close = !$invoice->is_close;
        $invoice->save();
        return $this->successMessage(Helper::StatusChangedSuccessFully());
    }

    //for export to pdf and Excel file
    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\InvoiceExport(), Helper::GenerateFileName('invoice', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\InvoiceExport(), Helper::GenerateFileName('invoice', ExportFormat::PDF->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
