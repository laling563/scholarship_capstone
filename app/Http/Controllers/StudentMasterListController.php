<?php

namespace App\Http\Controllers;

use App\Models\StudentMasterList;
use Illuminate\Http\Request;

class StudentMasterListController extends Controller
{
    public function create()
    {
        return view('Admin.student_master_list.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:student_master_list,student_id',
        ]);

        StudentMasterList::create($request->all());

        return redirect()->route('admin.student_master_list.create')->with('success', 'Student ID added successfully.');
    }
}
