@extends('layouts.app')

@section('content')
<h1>Modifier un admin user</h1>

<form action="#" method="POST">
    @csrf
    <label for="title">Titre :</label>
    <input type="text" id="title" name="title" required>
    <br>
    <label for="content">Contenu :</label>
    <textarea id="content" name="content" required></textarea>
    <br>
    <button type="submit">Enregistrer</button>
</form>

{-- Ici vous pourrez ajouter le contenu spécifique à cette vue --}
@endsection
