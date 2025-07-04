<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use Illuminate\Http\Request;

class ContenuController extends Controller
{
    public function index()
    {
        $contenus = Contenu::all();
        return view('contenus.index', compact('contenus'));
    }

    public function create()
    {
        return view('contenus.create');
    }

    public function store(Request $request)
    {
        Contenu::create($request->all());
        return redirect()->route('contenus.index');
    }

    public function show(Contenu $contenu)
    {
        return view('contenus.show', compact('contenu'));
    }

    public function edit(Contenu $contenu)
    {
        return view('contenus.edit', compact('contenu'));
    }

    public function update(Request $request, Contenu $contenu)
    {
        $contenu->update($request->all());
        return redirect()->route('contenus.index');
    }

    public function destroy(Contenu $contenu)
    {
        $contenu->delete();
        return redirect()->route('contenus.index');
    }

    public function apiContenus()
    {
        $contenus = Contenu::all();
        return response()->json(['articles' => $contenus]);
    }

}
