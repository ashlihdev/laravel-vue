<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('App/Home');
    }

    public function invoice()
    {
        $data['invoices'] = Invoice::all();

        return Inertia::render('App/Invoice')->with($data);
    }
}
