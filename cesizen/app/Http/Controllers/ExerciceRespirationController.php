<?php

namespace App\Http\Controllers;

use App\Models\ExerciceRespiration;
use Illuminate\Http\Request;

class ExerciceRespirationController extends Controller
{
    public function index() {
        $exercices = ExerciceRespiration::all();
        return view('exercice_respirations.index', compact('exercices'));
    }

    public function create() {
        return view('exercice_respirations.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'duree' => 'required|integer',
        ]);

        ExerciceRespiration::create($request->all());
        return redirect()->route('exercice_respirations.index');
    }

    public function show(ExerciceRespiration $exerciceRespiration) {
        return view('exercice_respirations.show', compact('exerciceRespiration'));
    }

    public function edit(ExerciceRespiration $exerciceRespiration) {
        return view('exercice_respirations.edit', compact('exerciceRespiration'));
    }

    public function update(Request $request, ExerciceRespiration $exerciceRespiration) {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'duree' => 'required|integer',
        ]);

        $exerciceRespiration->update($request->all());
        return redirect()->route('exercice_respirations.index');
    }

    public function destroy(ExerciceRespiration $exerciceRespiration) {
        $exerciceRespiration->delete();
        return redirect()->route('exercice_respirations.index');
    }
}
