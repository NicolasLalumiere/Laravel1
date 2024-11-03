@extends('layouts.app')
    
@section('content')

<style>
    .voyage {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    .voyage-details {
        flex: 1;
    }

    .voyage img {
        max-width: 300px;
        max-height: 200px;
        object-fit: cover;
        margin-left: 15px;
    }
</style>

<div class="voyage">
    <div class="voyage-details">
        <p>
            {{ $voyage->user->name }} : 
            <em>{{ $voyage->pays }}</em>, {{ $voyage->jours }} @lang('general.jours')
            
            @if ($voyage->transports->isNotEmpty())
                <ul>
                    @foreach ($voyage->transports as $transport)
                        <li>{{ htmlspecialchars($transport->type) }}</li>
                    @endforeach
                </ul>
            @endif

            @if (Auth::user())
                <form action="{{ route('voyages.edit', $voyage->id) }}" method="get" style="display:inline;">
                    @csrf
                    <button class="modifier" type="submit">@lang('general.Modifier')</button>
                </form>
                <form action="{{ route('voyages.destroy', $voyage->id) }}" method="post" style="display:inline;">
                    @csrf
                    @method('DELETE') 
                    <button class="supprimer" type="submit">@lang('general.Supprimer')</button>
                </form>
            @endif
        </p>
    </div>
    
    @if ($voyage->photo)
        <img src="{{ asset('storage/images/upload/' . $voyage->photo) }}" alt="Image de {{ $voyage->pays }}">
    @endif
</div>

@endsection