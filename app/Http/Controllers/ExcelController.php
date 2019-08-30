<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\User;

class ExcelController extends Controller
{
    public function exportUsers()
    {
        Excel::download();
    }
}
