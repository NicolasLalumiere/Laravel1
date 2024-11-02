@extends('layouts.app')

@section('content')

<style> body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f8;
        color: #333;
    }

    .container {
        max-width: 600px;
        margin: 30px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 1.8em;
        margin-bottom: 20px;
        color: #4a90e2;
        text-align: center;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    label {
        font-size: 1em;
        color: #333;
        margin-bottom: 5px;
    }

    input[type="text"], select {
        width: 100%;
        padding: 10px;
        border: 1px solid #d0d7de;
        border-radius: 5px;
        font-size: 1em;
        box-sizing: border-box;
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 5px;
        background-color: #4a90e2;
        color: #fff;
        font-size: 1.1em;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #357ab9;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            width: 90%;
        }
    }</style>

<div class="container">
    <h2>@lang('general.Ajout voyage')</h2>
    <form action="{{ route('voyages.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <p>
            <label for="pays">@lang('general.Pays')</label> :  
            <input type="text" name="pays" id="pays" required /><br />
            
            <label for="jours">@lang('general.jours')</label> :  
            <input type="text" name="jours" id="jours" required /><br />
            
            <!-- Champ pour télécharger une image -->
            <label for="photo">@lang('general.Photo')</label> :  
            <input type="file" name="photo" id="photo" required /><br />
            
            <input type="hidden" name="user_id" value="{{ $user->id }}" />  
            
            <input type="submit" value="@lang('general.Ajouter')" />
        </p>
    </form>
</div>

<div class="container">
    <h2>@lang('general.Ajout transport')</h2>
    <form action="{{ route('transports.store') }}" method="post">
        @csrf
        <p>
            <label for="voyage_id">@lang('general.Voyage')</label> :  
            <select name="voyage_id" id="voyage_id" required>
                @foreach ($voyagesUser as $voyage)
                    <option value="{{ $voyage->id }}">
                        {{ $voyage->pays }}
                    </option>
                @endforeach
            </select><br />
            
            <label for="type">@lang('general.Type')</label> :  
            <input type="text" name="type" id="type" required /><br />                
            <input type="submit" value=@lang('general.Ajouter') />
        </p>
    </form>
</div>

@endsection