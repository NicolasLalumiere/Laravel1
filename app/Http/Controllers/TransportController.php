<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'voyage_id' => 'required',
            'type'=>'required'
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with('warning','Tous les champs sont requis');    
        }
        else{
        Transport::create($request->all());
         return redirect()->back()->with('success', 'Votre commentaire a été ajouté');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    
    {
        $comment = Transport::findOrFail($id);
        $comment->delete();
    
        return redirect()->back()->with('success', 'Commentaire supprimé avec succès');
    } 
}
