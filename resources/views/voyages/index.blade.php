
@extends('layouts.app')
    
@section('content')

@foreach ($voyages as $voyage)
    <div class="voyage">
        <p>
            {{ $voyage->user->name }} : 
            <em>{{ $voyage->pays }}</em>, {{ $voyage->jours }} jours
            
            <?php if (!empty($voyage['transports'])): ?>
                <ul>
                    <?php foreach ($voyage['transports'] as $transport): ?>
                        <li><?= htmlspecialchars($transport['type']) ?></li>
                    <?php endforeach; ?>
                </ul>
                    <?php else: ?>
                        <p>Aucun transport pour ce voyage.</p>
                 <?php endif; ?>

            @if (Auth::user())
                <form action="{{ route('voyages.edit', $voyage->id) }}" method="get" style="display:inline;">
                    <button class="modifier" type="submit">Modifier</button>
                </form>
                <form action="{{ route('voyages.destroy', $voyage->id) }}" method="post" style="display:inline;">
                    @csrf
                    @method('DELETE') 
                    <button class="supprimer" type="submit">Supprimer</button>
                </form>
            @endif

            
        </p>
    </div>
@endforeach

@endsection 