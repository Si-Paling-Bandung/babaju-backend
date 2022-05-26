<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use App\Models\LocalOfficial;
use App\Models\RegionalDevice;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Rules\MatchOldPassword;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', '!=', 'admin')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . action('UsersController@update_view', $data->id) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . action('UsersController@delete', $data->id) . '" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"' . "onclick='return'" . '>Delete</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.user.user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_view()
    {
        $data_instance = Instance::all();
        $data_regional = LocalOfficial::all();
        return view('pages.user.create', compact('data_instance', 'data_regional'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_process(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role'  => ['required'],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        if ($request->role == "perangkat_daerah") {
            $user->id_local_official = $request->id_local_official;
        } elseif ($request->role == "kader" || $request->role == "tenaga_kesehatan" || $request->role == "trainer")  {
            $user->id_instansi = $request->id_instance;
        }

        $user->save();

        return redirect()->route('user')->withSuccess('User created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_view($id)
    {
        $data = User::find($id);
        $data_instance = Instance::all();
        $data_regional = LocalOfficial::all();
        return view('pages.user.update', compact('data','data_instance','data_regional'));
    }

    public function update_process(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', Rule::unique('users', 'username')->ignore($user)],
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        if ($user->role == "perangkat_daerah") {
            $user->id_regional_device = $request->id_regional_device;
        } elseif ($request->role == "kader" || $request->role == "tenaga_kesehatan" || $request->role == "trainer") {
            $user->id_instansi = $request->id_instance;
        }
        $user->save();

        return redirect()->route('user')->withSuccess('User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('user')->withSuccess('User deleted successfully.');
    }

    public function change_password(Request $request, $id)
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find($id)->update(['password' => bcrypt($request->new_password)]);
        return redirect()->route('user')->withSuccess('User password changed successfully.');
    }
}
