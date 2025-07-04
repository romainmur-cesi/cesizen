<?php

namespace App\Http\Controllers;

use App\Models\Consulter;
use Illuminate\Http\Request;

class ConsulterController extends Controller
{
    public function index() {
        $consultations = Consulter::all();
        return view('consulters.index', compact('consultations'));
    }

    public function create() {
        return view('consulters.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            // Adapte ici les règles selon les champs de ta table Consulter
        ]);

        Consulter::create($request->all());
        return redirect()->route('consulters.index');
    }

    public function show(Consulter $consulter) {
        return view('consulters.show', compact('consulter'));
    }

    public function edit(Consulter $consulter) {
        return view('consulters.edit', compact('consulter'));
    }

    public function update(Request $request, Consulter $consulter) {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            // Adapte ici aussi les règles de validation
        ]);

        $consulter->update($request->all());
        return redirect()->route('consulters.index');
    }

    public function destroy(Consulter $consulter) {
        $consulter->delete();
        return redirect()->route('consulters.index');
    }
}
