<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;

class GroupController extends Controller
{
    public function index()
    {
        return view('admin.groupe.index', ['groups' => Group::all()]);
    }

    public function create()
    {
        return view('admin.groupe.create', ['group' => new Group]);
    }

    public function store(Request $request, Group $group)
    {
        $group = $group->create($request->all());

        return redirect()->route('admin.group.index')->with('success', 'Group created');
    }

    public function edit(Group $group)
    {
        return view('admin.groupe.edit', ['group' => $group]);
    }

    public function update(Request $request, Group $group)
    {
        $group->update($request->all());

        return redirect()->route('admin.group.index')->with('success', 'Group updated');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
