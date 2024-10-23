<?php

namespace App\Http\Controllers;

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
        return view('voyages.index', compact('voyages'));
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
                'id_utilisateur' => 'required|integer',
            ]);
    
            // Créer un nouveau voyage
            Voyage::create($validatedData);
    
            // Rediriger vers une page ou afficher un message de succès
            return redirect()->back()->with('success', 'Voyage ajouté avec succès!');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
