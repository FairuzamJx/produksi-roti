<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index()
    {
        $rules = Rule::all();
        return view('rule.index', compact('rules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'r1' => 'required',
            'r2' => 'required',
            'r3' => 'required',
            'r4' => 'required',
        ]);

        Rule::create($request->all());

        return redirect()->back()->with('success', 'Rule berhasil disimpan');
    }
}
