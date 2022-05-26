<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use DataTables;
use App\Traits\SummernoteWithUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AnnouncementController extends Controller
{
    use SummernoteWithUpload;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Announcement::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('announcement.update', $data->id) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . route('announcement.delete', $data->id) . '" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"' . "onclick='return'" . '>Delete</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.announcement.announcement');
    }

    public function create_view()
    {
        return view('pages.announcement.create');
    }

    public function create_process(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'editor1' => 'required',
        ]);

        $announcement = new Announcement();
        $announcement->title = $request->title;
        $announcement->text = htmlspecialchars_decode($this->summernote($request['editor1']));
        $announcement->save();

        return redirect()->route('announcement')->withSuccess('Announcement created successfully.');
    }

    public function update_view($id_announcement)
    {
        $data = Announcement::find($id_announcement);
        return view('pages.announcement.update', compact('data'));
    }

    public function update_process(Request $request, $id_announcement)
    {
        $request->validate([
            'title' => 'required',
            'editor1' => 'required',
        ]);

        $data = Announcement::find($id_announcement);
        $data->title = $request->title;
        $data->text = htmlspecialchars_decode($this->summernote($request['editor1']));
        $data->save();

        return redirect()->route('announcement')->withSuccess('Announcement updated successfully.');
    }

    public function delete($id_announcement)
    {
        $data = Announcement::find($id_announcement);
        $data->delete();

        return redirect()->route('announcement')->withSuccess('Announcement deleted successfully.');
    }
}
