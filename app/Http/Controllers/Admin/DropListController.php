<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationForm;
use App\Models\DropList;
use Illuminate\Http\Request;

class DropListController extends Controller
{
    public function index()
    {
        $droppedStudents = ApplicationForm::where('status', 'Rejected')->get();

        return view('Admin.droplist', compact('droppedStudents'));
    }
}
