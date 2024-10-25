<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Article;
use App\Models\Voyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VoyageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $voyages = Voyage::with('user')->get();
        $voyages = Voyage::paginate(5);
        $user = auth()->user(); // Récupère l'utilisateur connecté
        if ($user) {
            // Si l'utilisateur est connecté
            $voyages = Voyage::where('user_id', $user->id)->paginate(5);
            return view('voyages.index', compact('voyages', 'user'));
        } else {
            return view('voyages.index', compact('voyages'));
        }       
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $voyages = Voyage::all(); // Assure-toi d'importer ton modèle Voyage
        $user = auth()->user(); // Récupère l'utilisateur connecté
    
        return view('ajouter', compact('voyages', 'user'));
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
            // Valider les données
            $validatedData = $request->validate([
                'pays' => 'required|string|max:255',
                'jours' => 'required|integer',
                'user_id' => 'required|integer',
            ]);
    
            // Créer un nouveau voyage
            Voyage::create($validatedData);
    
            // Rediriger vers une page ou afficher un message de succès
            return redirect('/')->with('success', 'Voyage ajouté avec succès!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $voyage = Voyage::findOrFail($id); // Récupérer le voyage par ID
        $user = Auth::user();
        return view('modifier', compact('voyage', 'user')); // Passer le voyage à la vue
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // Valider les données
        $validatedData = $request->validate([
            'pays' => 'required|string|max:255',
            'jours' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        // Trouver le voyage par ID et mettre à jour les données
        $voyage = Voyage::findOrFail($id);
        $voyage->update($validatedData);

    // Rediriger vers une page ou afficher un message de succès
    return redirect('/')->with('success', 'Voyage modifié avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Trouver le voyage par son ID
    $voyage = Voyage::findOrFail($id);

    // Supprimer le voyage
    $voyage->delete();

    // Rediriger vers une page avec un message de succès
    return redirect()->route('voyages.index')->with('success', 'Voyage supprimé avec succès!');
    }
}
