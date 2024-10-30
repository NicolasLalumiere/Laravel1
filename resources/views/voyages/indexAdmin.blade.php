@extends('layouts.app')
    
@section('content')

@foreach ($voyages as $voyage)
    <div class="voyage">
        <p>
            {{ $voyage->user->name }} : 
            <em>{{ $voyage->pays }}</em>, {{ $voyage->jours }} @lang('general.jours')
            
            <?php if (!empty($voyage['transports'])): ?>
                <ul>
                    <?php foreach ($voyage['transports'] as $transport): ?>
                        <li><?= htmlspecialchars($transport['type']) ?></li>
                    <?php endforeach; ?>
                </ul>
                 <?php endif; ?>

                <form action="{{ route('voyages.destroy', $voyage->id) }}" method="post" style="display:inline;">
                    @csrf
                    @method('DELETE') 
                    <button class="supprimer" type="submit">@lang('general.Supprimer')</button>
                </form>

            
        </p>
    </div>
@endforeach

@endsection 