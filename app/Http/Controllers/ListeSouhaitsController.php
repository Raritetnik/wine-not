<?php

namespace App\Http\Controllers;

use App\Models\Bouteille_Par_Cellier;
use App\Models\ListeSouhaits;
use App\Models\Pays;
use App\Models\Vino_Bouteille;
use App\Models\Vino_Format;
use App\Models\Vino_Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class ListeSouhaitsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Affichage de catalogue des bouteillés favoris
     */
    public function index()
    {
       $liste = ListeSouhaits::where('utilisateurs_id', Auth::user()->id)->get();
        // Filtrage des bouteilles, seules en favoris
        $listeBouteilles = [];
        foreach ($liste as $btl) {
            $bouteilleFav = Vino_Bouteille::find($btl->vino_bouteilles_id);
            $bouteilleFav['pays'] = (Pays::where("id",$bouteilleFav->pays_id)->exists()) ? Pays::find($bouteilleFav->pays_id)['pays'] : 'Pays indéfini';
            $bouteilleFav['format'] = (Vino_Format::where("id",$bouteilleFav->vino_format_id)->exists()) ? Vino_Format::find($bouteilleFav->vino_format_id)['format'] : 'Format indéfini';
            array_push($listeBouteilles, $bouteilleFav);
        }
        return view('listeSouhaits', ['bouteilles' => $listeBouteilles, 'liste' => $liste]);
    }

    /**
     * Vérification si l'utilisateur a la bouteille en favoris
     */
    public function verifierFavoris($id) {
        return (ListeSouhaits::where('vino_bouteilles_id', $id)->where('utilisateurs_id', Auth::user()->id)->exists()) ? true : false;
    }

    /**
     * Modification de l'état favoris par l'utilisateur
     */
    public function modifierFavoris(Request $request) {
        if(!ListeSouhaits::where('vino_bouteilles_id', $request['BouteilleID'])->where('utilisateurs_id', Auth::user()->id)->exists()) {
            ListeSouhaits::create([
                'vino_bouteilles_id' => $request['BouteilleID'],
                'utilisateurs_id' => Auth::user()->id,
            ]);
        } else {
            ListeSouhaits::where('vino_bouteilles_id', $request['BouteilleID'])->where('utilisateurs_id', Auth::user()->id)->delete();
        }
    }
}
