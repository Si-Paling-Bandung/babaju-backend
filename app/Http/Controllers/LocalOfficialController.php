<?php

namespace App\Http\Controllers;

use App\Models\LocalOfficial;
use Illuminate\Http\Request;
use DataTables;

class LocalOfficialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LocalOfficial::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('local-official.update', $data->id) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . route('local-official.delete', $data->id) . '" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"' . "onclick='return'" . '>Delete</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.regional.regional');
    }

    public function create_view()
    {
        return view('pages.regional.create');
    }

    public function create_process(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $regional = new LocalOfficial();
        $regional->title = $request->title;
        $regional->save();

        return redirect()->route('local-official')->withSuccess('Local Official created successfully.');
    }

    public function update_view($id_regional)
    {
        $data = LocalOfficial::find($id_regional);
        return view('pages.regional.update', compact('data'));
    }

    public function update_process(Request $request, $id_regional)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $data = LocalOfficial::find($id_regional);
        $data->title = $request->title;
        $data->save();

        return redirect()->route('local-official')->withSuccess('Local Official updated successfully.');
    }

    public function delete($id_regional)
    {
        $data = LocalOfficial::find($id_regional);
        $data->delete();

        return redirect()->route('local-official')->withSuccess('Local Official deleted successfully.');
    }
}
