<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Admin/Home');
    }

    public function invoice()
    {
        $data['invoices'] = Invoice::all();


        return Inertia::render('Admin/Invoice')->with($data);
    }
}
