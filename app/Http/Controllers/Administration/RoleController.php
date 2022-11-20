<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Get all batch lists
     *
     * @return void
     */

    public function getList()
    {
        try {
            $data = Role::get();

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('permissions', function ($data) {
                    $roles = $data->permissions()->get();
                    $badges = '';

                    foreach ($roles as $key => $role) {
                        $badges .= '<span class="badge me-1 bg-info m-1">'.$role->title.'</span>';
                    }

                    if ($data->name == 'Super Admin') {
                        return '<span class="badge me-1 bg-success m-1">All permissions</span>';
                    }

                    return $badges;
                })
                ->addColumn('action', function ($data) {
                    if ($data->name == 'Super Admin' || $data->name == 'Students' || $data->name == 'Teachers') {
                        return '';
                    }
//                    return '<div class = "btn-group">
//                                <a href="' . route('admin.roles.edit', $data->id) . '" class="btn btn-sm btn-warning"><i class=\'bx bxs-edit-alt\'></i></a>
//                                <a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>
//
//                            </div>';
                    return '<div class = "btn-group">
                                <a href="' . route('admin.roles.edit', $data->id) . '" class="btn btn-sm btn-warning" title="edit"><i class=\'bx bxs-edit-alt\'></i></a>                                       
                            </div>';
                })
                ->rawColumns(['action', 'permissions'])
                ->make(true);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('dashboard.administration.roles.index');
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $modules = Module::with('permissions')->get();
            return view('dashboard.administration.roles.create', compact('modules'));
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name'
        ]);

        try {
            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->permissions);

            if ($role) {
                return redirect()->route('admin.roles.index')
                        ->with('t-success', 'Role created succesfully!');
            } else {
                return back()->with('t-error', 'Failed to create role! Try again.');
            }

        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $role = Role::findOrFail($id);
            // if role exist
            if ($role) {
                $modules = Module::all();
                return view('dashboard.administration.roles.edit', compact('modules', 'role'));
            } else {
                return redirect('404');
            }
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'role' => 'required',
        ]);

        try {
            $role = Role::findOrFail($id);
            $role->update([
                'name' => $request->role,
            ]);
            $role->syncPermissions($request->permissions);

            return redirect()->route('admin.roles.index')
                ->with('t-success', 'Role updated successfully');
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrfail($id);

            $role->delete();
            $role->permissions()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role Deleted Successfully.',
            ]);

        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
