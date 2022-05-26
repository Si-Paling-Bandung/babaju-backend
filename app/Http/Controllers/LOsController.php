<?php

namespace App\Http\Controllers;

use App\Models\LOs;
use App\Models\Topics;
use Illuminate\Http\Request;
use DataTables;

class LOsController extends Controller
{
    public function index(Request $request, $id_topic)
    {
        $topic = Topics::find($id_topic);
        if (is_null($topic)) {
            return redirect()->to('topic')->withErrors("Topic not correct, please dont change from url");
        }

        if ($request->ajax()) {
            $data = LOs::where("id_topic", "=", $id_topic)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('lesson', [$data->id_topic , $data->id]) . '" type="button" name="detail" id="' . $data->id . '" class="detail btn btn-success btn-sm">Detail</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<a href="' . route('lo.update', [$data->id_topic , $data->id]) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . route('lo.delete', [$data->id_topic, $data->id]) . '" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"' . "onclick='return'" . '>Delete</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.lo.lo', compact('topic'));
    }

    public function create_view($id_topic)
    {
        return view('pages.lo.create', compact('id_topic'));
    }

    public function create_process(Request $request, $id_topic)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $lo = new LOs();
        $lo->id_topic = $id_topic;
        $lo->name = $request->name;
        $lo->description = $request->description;

        $lo->save();

        return redirect()->route('lo', $id_topic)->withSuccess('LOs created successfully.');
    }

    public function update_view($id_topic, $id_lo)
    {
        // Check LO and Topic
        $data = LOs::find($id_lo);
        if ($data->id_topic != $id_topic) {
            return redirect()->route('lo', $id_topic)->withErrors("LOs not correct, please dont change from url");
        }

        return view('pages.lo.update', compact('id_topic','data'));
    }

    public function update_process(Request $request, $id_topic, $id_lo)
    {
        // Check LO and Topic
        $data = LOs::find($id_lo);
        if ($data->id_topic != $id_topic) {
            return redirect()->route('lo', $id_topic)->withErrors("LOs not correct, please dont change from url");
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $data->name = $request->name;
        $data->description = $request->description;

        $data->save();
        return redirect()->route('lo', $id_topic)->withSuccess('LOs updated successfully.');
    }

    public function delete($id_topic, $id_lo)
    {
        // Check LO and Topic
        $data = LOs::find($id_lo);
        if ($data->id_topic != $id_topic) {
            return redirect()->route('lo', $id_topic)->withErrors("LOs not correct, please dont change from url");
        }

        $data->delete();

        return redirect()->route('lo', $id_topic)->withSuccess('LOs deleted successfully.');
    }
}
