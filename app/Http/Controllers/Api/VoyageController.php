<?php

namespace App\Http\Controllers\Api;

use App\Models\Voyage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class VoyageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user(); // Récupère l'utilisateur connecté
    
        if ($user !== null) { // Si un utilisateur est connecté
            $voyages = Voyage::where('user_id', $user->id)->get();
        } else { // Si aucun utilisateur n'est connecté
            $voyages = Voyage::all();
        }
    
        // Retourne toujours la réponse JSON
        return response()->json($voyages, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $voyage = $request->all();
        
        $request->validate([
        'user_id' => 'required',
        'pays'     => 'required',
        'jours'   => 'required',
        'photo'     => 'required|image'
    ]);

    if ($voyage = $request ->file('photo')){
        $image = $request->photo;
        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->move('images/upload', $fileName, 'public');
    }

    $voyage =  Voyage::create([
        'user_id' => $request->input('user_id'),
        'pays' => $request->input('pays'),
        'jours' => $request->input('jours'),
        'photo' => $fileName,
    ]);
  
      // On retourne les informations du nouvel article en JSON
     return response()->json([$voyage,"message" => "Voyage ajouté"], 201);  
    }
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Voyage::find($id);
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
        $voyage = Voyage::findOrFail($id);
        if (!$voyage) {
            return response() ->json(['message' => 'Id not found'], 404);
        }
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'pays'=> 'required',
            'jours'=> 'required',
            'photo'=> 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        if ($validator->fails()) {
            return response() ->json(['success' => false, 'message' => $validator->errors()], 400);
        }
 
        if ($request->hasfile('photo')) {
            $image = $request->photo;
            $path = $request->photo->storeAs('images/upload', 'public');
            $article['photo'] = $path;
    
        }
        $voyage->update($request->except('photo'));

        return response()->json([$voyage,"message" => "Article modifé avec succees" ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voyage = Voyage::findOrFail($id);
        if ($voyage->photo) {
            Storage::disk('public')->delete($voyage->photo);
        }
          $voyage->delete();
        return response()->json(null, 204);
    }

    public function getUserVoyages()
{
    $userId = Auth::id();
    if (!$userId) {
        return response()->json(['message' => 'Utilisateur non authentifié'], 401);
    }
    $voyages = Voyage::where('user_id', $userId)->get();
    return response()->json($voyages);
}

public function getMyPosts(){    
     $user = auth()->user();     $posts = $user->posts; // Récupère les posts de l'utilisateur connectéreturn response()->json($posts); 
    }


    public function autocomplete(Request $request)
{
    $query = $request->input('query');
    $voyages = Voyage::where('pays', 'like', '%' . $query . '%')->get();
    
    return response()->json($voyages);
}

    
}
