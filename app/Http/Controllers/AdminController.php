<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CompanySetting;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function AdminDashboard() {
        $date = date('Y-m-d');
        $today_paid = Order::where('order_date', $date)->sum('pay');
        $total_paid = Order::sum('pay');
        $total_due = Order::sum('due'); 
        $completeorder = Order::where('order_status', 'complete')->get(); 
        $pendingorder = Order::where('order_status', 'pending')->get(); 
    
        // Monthly Revenue Logic for Chart
        $daysInMonth = now()->daysInMonth;
        $currentMonth = now()->month;
        $currentYear = now()->year;
    
        $monthlyRevenue = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->selectRaw('DAY(created_at) as day, SUM(pay) as total')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();
    
        $chartLabels = [];
        $chartData = [];
    
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $chartLabels[] = $i;
            $chartData[] = $monthlyRevenue[$i] ?? 0;
        }
    
        return view('index', compact(
            'today_paid', 'total_paid', 'total_due', 
            'completeorder', 'pendingorder', 'date',
            'chartLabels', 'chartData'
        ));
    }
    
    public function AdminDestroy(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = [
            'message' => 'Logout Successfully',
            'alert-type' => 'info'
        ];

        return redirect('/login')->with($notification);
    }

    public function AdminProfile(Request $request){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view', compact('adminData'));
    }

    public function AdminProfileStore(Request $request) {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'phone'     => 'nullable|string|max:20',
        ]);

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->lastname = $request->lastname;
        $data->firstname = $request->firstname;
        $data->phone = $request->phone;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            if ($data->photo && file_exists(public_path('upload/admin_image/'.$data->photo))) {
                @unlink(public_path('upload/admin_image/'.$data->photo));
            }

            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_image'), $filename);
            $data->photo = $filename;
        }

        $data->save();

        $notification = [
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function AdminChangePasswordUpdate(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)){
            $notification = [
                'message' => 'Old password does not match',
                'alert-type' => 'error'
            ];
            return back()->with($notification);
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = [
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($notification);
    }

    /* Admin User Management */

    public function AllAdmin(){
        $alladminuser = User::latest()->get();
        return view('backend.admin.all_admin', compact('alladminuser'));
    }

    public function AddAdmin(){
        $roles = Role::all();
        return view('backend.admin.add_admin', compact('roles'));
    }

    public function StoreAdmin(Request $request){
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|min:6',
            'roles'    => 'required',
        ], [
            'email.unique' => 'This email address is already registered.',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();
    
        if ($request->roles) {
            $role = Role::find($request->roles);
            if ($role) {
                $user->assignRole($role->name);
            }
        }
    
        $notification = [
            'message' => 'New Admin User Created Successfully',
            'alert-type' => 'success'
        ];
    
        return redirect()->route('all.admin')->with($notification);
    }

    public function EditAdmin($id){
        $roles = Role::all();
        $adminuser = User::findOrFail($id);
        return view('backend.admin.edit_admin', compact('roles', 'adminuser'));
    }

    public function UpdateAdmin(Request $request){
        $admin_id = $request->id;

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$admin_id,
            'phone' => 'required|string|max:20',
            'roles' => 'required',
        ]);
    
        $user = User::findOrFail($admin_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
    
        $user->roles()->detach();
    
        if ($request->roles) {
            $role = Role::find($request->roles);
            if ($role) {
                $user->assignRole($role->name);
            }
        }
    
        $notification = [
            'message' => 'Admin User Updated Successfully',
            'alert-type' => 'success'
        ];
    
        return redirect()->route('all.admin')->with($notification);
    }

    public function DeleteAdmin($id){
        $user = User::findOrFail($id);
        if (!is_null($user)) {
            $user->delete();
        }

        $notification = [
            'message' => 'Admin User Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification); 
    }

    /* Database Backup Methods */

    public function DatabaseBackup(){
        $path = storage_path('/app/ThrivePOS');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        return view('admin.db_backup')->with('files', File::allFiles($path));
    }
    
    public function BackupNow(){
        \Artisan::call('backup:run');
        return redirect()->back()->with([
            'message' => 'Database Backup Successfully',
            'alert-type' => 'success'
        ]);
    }
    
    public function DownloadDatabase($getFilename){
        $path = storage_path('app/ThrivePOS/'.$getFilename);
        return response()->download($path);
    }
    
    public function DeleteDatabase($getFilename){
        Storage::delete('ThrivePOS/'.$getFilename);
        return redirect()->back()->with([
            'message' => 'Database Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    /* Company Setup */

    public function CompanyUpdate(Request $request)
    {
        $company_id = $request->id;

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'contact' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',                
            'logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company = CompanySetting::findOrFail($company_id);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'contact'    => $request->contact,
            'address'    => $request->address,                
            'tin'        => $request->tin,                
            'updated_at' => Carbon::now(),
        ];

        if ($request->file('logo')) {
            if ($company->logo && file_exists(public_path($company->logo))) {
                unlink(public_path($company->logo));
            }
            
            $image = $request->file('logo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::read($image)
                ->scale(width: 300) 
                ->save(public_path('upload/company/' . $name_gen));

            $data['logo'] = 'upload/company/' . $name_gen;
        }

        $company->update($data);

        return redirect()->route('company.setting')->with([
            'message'    => 'Company Setting Updated Successfully',
            'alert-type' => 'success',
        ]);
    }
}