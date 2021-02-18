<?php

/**
* Description:
* Controller (based on MVC architecture) for the management of form groups
* All the methods are available only for the admin
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - index() | Show the list of form groups
* - create() | Create new form group
* - store(Request $request, Group $group) | Store just created new form group (POST method)
* - edit(Group $group) | Edit form group
* - update(Request $request, Group $group) | Update form group (PUT method)
* - destroy(Group $group) | Delete form group (DELETE method)
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;
use App\USer;

class GroupController extends Controller
{

    /**
    * Description:
    * Show the list of form groups
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/group
    */
    public function index()
    {
        return view('admin.groupe.index', ['groups' => Group::all()]);
    }


    /**
    * Description:
    * Create new form group
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/group/create
    */
    public function create()
    {
        return view('admin.groupe.create', [
            'group' => new Group,
            'managers' => User::where('role', 'manager')->orderBy('last_name', 'ASC')->get()
        ]);
    }


    /**
    * Description:
    * Store just created new form group (POST method)
    *
    * List of parameters:
    * - $request : Request
    * - $group : Group
    *
    * Return:
    * view content, redirects to the list of form groups
    *
    * Examples of usage:
    * - create new Form Group, prefill it and click "Save"
    */
    public function store(Request $request, Group $group)
    {
        $group = $group->create($request->except('managers'));

        // Groups attach
        if ($request->has('managers')) {
            $group->managers()->attach($request->input('managers'));
        }

        return redirect()->route('admin.group.index')->with('success', 'Group created');
    }


    /**
    * Description:
    * Edit form group
    *
    * List of parameters:
    * - $group : Group
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/group/1/edit
    */
    public function edit(Group $group)
    {
        return view('admin.groupe.edit', [
            'group' => $group,
            'managers' => User::where('role', 'manager')->orderBy('last_name', 'ASC')->get()
        ]);
    }


    /**
    * Description:
    * Update form group (PUT method)
    *
    * List of parameters:
    * - $request : Request
    * - $group : Group
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/group/1/edit and click "Save"
    */
    public function update(Request $request, Group $group)
    {
        $group->update($request->except('managers'));

        $group->managers()->detach();
        // Groups attach
        if ($request->has('managers')) {
            $group->managers()->attach($request->input('managers'));
        }

        return redirect()->route('admin.group.index')->with('success', 'Group updated');
    }


    /**
    * Description:
    * Delete form group (DELETE method)
    *
    * List of parameters:
    * - $group : Group
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/group and click to trash icon at any item in the list
    */
    public function destroy(Group $group)
    {
        $group->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
