
@extends('layouts.app')
    
@section('content')

@foreach ($voyages as $index => $voyage)

    <voyage>
    <div class="voyage">
    <p>
          
            {{ $voyage->user->prenom }} : 
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
                </p>
        </div>
</voyage>

@endforeach

@endsection 