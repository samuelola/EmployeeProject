<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Library\Utilities;
use App\Http\Requests\ProjectRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $date = Carbon::now();
        $project_data = $request->validated();
        $newProject = new Project;
        $newProject->name = $project_data['name'];
        $newProject->description = $project_data['description'];
        $newProject->status = 1;
        $newProject->start_date = $date;
        $newProject->end_date = $date->addDays(30);
        $newProject->save();
        return Utilities::sendResponse(new ProjectRequest($newProject), 'Project Data saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $find_project = Project::where('id',$id)->orderByDesc('created_at')->first();
         if (is_null($find_project )) {
            return Utilities::sendError('Project not found.');
        }else{
            return Utilities::sendResponse(new ProjectResource($find_project), 'Project retrieved successfully.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id,Project $project)
    {
        if(Gate::denies('update',$project)){
            return abort(403,'forbidden for this action');
        };

        $find_project = Project::where('id',$id)->orderByDesc('created_at')->first();
        if (is_null($find_project)) {
            return Utilities::sendError('Project not found.');
        }else{
           $project_data = $request->validated();
           $find_project->update($project_data);
           return Utilities::sendResponse($find_project, 'Project Updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if(Gate::denies('delete',$project)){
            return abort(403,'forbidden for this action');
        };
        $project->delete();
        return Utilities::sendResponse('Deleted','Project Deleted successfully.');
    }
}
