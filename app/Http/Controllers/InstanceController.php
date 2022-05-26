<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use Illuminate\Http\Request;
use DataTables;

class InstanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Instance::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('instance.update', $data->id) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . route('instance.delete', $data->id) . '" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"' . "onclick='return'" . '>Delete</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.instance.instance');
    }

    public function create_view()
    {
        return view('pages.instance.create');
    }

    public function create_process(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $instance = new Instance();
        $instance->title = $request->title;
        $instance->save();

        return redirect()->route('instance')->withSuccess('Instance created successfully.');
    }

    public function update_view($id_instance)
    {
        $data = Instance::find($id_instance);
        return view('pages.instance.update', compact('data'));
    }

    public function update_process(Request $request, $id_instance)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $data = Instance::find($id_instance);
        $data->title = $request->title;
        $data->save();

        return redirect()->route('instance')->withSuccess('Instance updated successfully.');
    }

    public function delete($id_instance)
    {
        $data = Instance::find($id_instance);
        $data->delete();

        return redirect()->route('instance')->withSuccess('Instance deleted successfully.');
    }
}
