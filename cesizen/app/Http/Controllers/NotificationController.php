<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index() {
        $notifications = Notification::all();
        return view('notifications.index', compact('notifications'));
    }

    public function create() {
        return view('notifications.create');
    }

    public function store(Request $request) {
        $request->validate([
            'id_utilisateur' => 'required|integer|exists:utilisateurs,id',
            'type' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Notification::create($request->all());

        return redirect()->route('notifications.index');
    }

    public function show(Notification $notification) {
        return view('notifications.show', compact('notification'));
    }

    public function edit(Notification $notification) {
        return view('notifications.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification) {
        $request->validate([
            'id_utilisateur' => 'required|integer|exists:utilisateurs,id',
            'type' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $notification->update($request->all());

        return redirect()->route('notifications.index');
    }

    public function destroy(Notification $notification) {
        $notification->delete();

        return redirect()->route('notifications.index');
    }
}
