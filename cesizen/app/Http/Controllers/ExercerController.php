<?php

namespace App\Http\Controllers;

use App\Models\Exercer;
use Illuminate\Http\Request;

class ExercerController extends Controller
{
    public function index() {
        $exercers = Exercer::all();
        return view('exercers.index', compact('exercers'));
    }

    public function create() {
        return view('exercers.create');
    }

    public function store(Request $request) {
        $request->validate([
            'id_exercice_respiration' => 'required|integer|exists:exercice_respirations,id',
            'id_utilisateur' => 'required|integer|exists:utilisateurs,id',
        ]);

        Exercer::create($request->all());
        return redirect()->route('exercers.index');
    }

    public function show(Exercer $exercer) {
        return view('exercers.show', compact('exercer'));
    }

    public function edit(Exercer $exercer) {
        return view('exercers.edit', compact('exercer'));
    }

    public function update(Request $request, Exercer $exercer) {
        $request->validate([
            'id_exercice_respiration' => 'required|integer|exists:exercice_respirations,id',
            'id_utilisateur' => 'required|integer|exists:utilisateurs,id',
        ]);

        $exercer->update($request->all());
        return redirect()->route('exercers.index');
    }

    public function destroy(Exercer $exercer) {
        $exercer->delete();
        return redirect()->route('exercers.index');
    }
}
