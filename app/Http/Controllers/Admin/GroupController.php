<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;
use App\USer;

class GroupController extends Controller
{
    public function index()
    {
        return view('admin.groupe.index', ['groups' => Group::all()]);
    }

    public function create()
    {
        return view('admin.groupe.create', [
            'group' => new Group,
            'managers' => User::where('role', 'manager')->orderBy('last_name', 'ASC')->get()
        ]);
    }

    public function store(Request $request, Group $group)
    {
        $group = $group->create($request->except('managers'));

        // Groups attach
        if ($request->has('managers')) {
            $group->managers()->attach($request->input('managers'));
        }

        return redirect()->route('admin.group.index')->with('success', 'Group created');
    }

    public function edit(Group $group)
    {
        return view('admin.groupe.edit', [
            'group' => $group,
            'managers' => User::where('role', 'manager')->orderBy('last_name', 'ASC')->get()
        ]);
    }

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

    public function destroy(Group $group)
    {
        $group->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
