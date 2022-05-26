<?php

namespace App\Http\Controllers;

use App\Models\ProjectFunding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProjectFundingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = ProjectFunding::where('id_project', $id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . route('crowdfunding.funding.delete', [$data->id_project, $data->id]) . '" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"' . "onclick='return'" . '>Delete</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.crowdfunding.funding', compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_view(Request $request, $id)
    {
        $data_user = User::all();
        return view('pages.crowdfunding.funding-create', compact('id', 'data_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_process(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required',
            'notes' => 'required',
            'user' => 'required',
        ]);

        $project_funding = new ProjectFunding();
        $project_funding->id_project = $id;
        $project_funding->id_user = $request->user;
        $project_funding->amount = $request->amount;
        $project_funding->notes = $request->notes;
        $project_funding->save();

        return redirect()->route('crowdfunding.funding', compact('id'))->withSuccess('Crowd Funding created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function delete($id_product_variant, $id)
    {
        $project_funding = ProjectFunding::find($id);
        $project_funding->delete();

        return redirect()->route('crowdfunding.funding', $id_product_variant)->withSuccess('Crowd Funding deleted successfully.');
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
     * @param  \App\Models\ProjectFunding  $projectFunding
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectFunding $projectFunding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectFunding  $projectFunding
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectFunding $projectFunding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectFunding  $projectFunding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectFunding $projectFunding)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectFunding  $projectFunding
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectFunding $projectFunding)
    {
        //
    }
}
