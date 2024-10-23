@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Ajoutez un voyage!</h2>
    <form action="{{ route('voyages.ajout') }}" method="post">
        @csrf
        <p>
            <label for="pays">Pays</label> :  
            <input type="text" name="pays" id="pays" required /><br />
            
            <label for="jours">Jours</label> :  
            <input type="text" name="jours" id="jours" required /><br />
            
            <input type="hidden" name="id_utilisateur" value="{{ $user->id }}" />  
            
            <input type="submit" value="Ajouter" />
        </p>
    </form>
</div>

<div class="container">
    <h2>Ajoutez un transport pour un voyage!</h2>
    <form action="{{ route('transports.ajouter') }}" method="post">
        @csrf
        <p>
            <label for="id_voyage">Voyage</label> :  
            <select name="id_voyage" id="id_voyage" required>
                @foreach ($voyages as $voyage)
                    <option value="{{ $voyage->id }}">
                        {{ $voyage->pays }}
                    </option>
                @endforeach
            </select><br />
            
            <label for="type">Type</label> :  
            <input type="text" name="type" id="type" required /><br />                
            <input type="submit" value="Ajouter" />
        </p>
    </form>
</div>

@endsection