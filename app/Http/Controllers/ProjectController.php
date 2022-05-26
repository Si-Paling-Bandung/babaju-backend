<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Project::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . route('crowdfunding.delete', $data->id) . '" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"' . "onclick='return'" . '>Delete</a>';
                    return $button;
                })->addColumn('photo', function ($data) {
                    return '<img src="' . Storage::url($data->cover_image) . '" width="100px" height="100px" />';
                })
                ->rawColumns(['action', 'photo'])
                ->make(true);
        }

        return view('pages.crowdfunding.crowdfunding');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_view()
    {
        $data_category = \App\Models\ProjectCategory::all();
        return view('pages.crowdfunding.create', compact('data_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_process(Request $request)
    {
        $request->validate([
            'project_category' => 'required',
            'cover_image' => 'required',
            'title' => 'required',
            'content'  => 'required',
            'lat'  => 'required',
            'lang'  => 'required',
            'location'  => 'required',
            'attachment'  => '',
        ]);

        $education = new Project();
        $education->id_user = Auth::user()->id;
        $education->id_project_category  = $request->project_category;
        $education->cover_image = Storage::disk('public')->put('education', $request->file('cover_image'));
        $education->title = $request->title;
        $education->content = $request->content;
        $education->lat = $request->lat;
        $education->lang = $request->lang;
        $education->location = $request->location;
        if($request->hasFile('attachment')){
            $education->attachment = Storage::disk('public')->put('education', $request->file('attachment'));
        }
        $education->attachment = $request->attachment;
        $education->status = 'publish';
        $education->save();

        return redirect()->route('crowdfunding')->withSuccess('Crowd Funding Post created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $project = Project::find($id);
        $project->delete();

        return redirect()->route('crowdfunding')->withSuccess('Crowd Funding Post deleted successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
