<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Organizer;
use App\Models\Location;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;
// use App\Policies\EventPocicy;
// use Carbon\Carbon;

class EventController extends Controller
{
    // RECHERCHE PAR UN MOT CLEF
    public function search(Request $request)
    {
        $query = $request->input('query');

        $events = Event::where('theme', 'LIKE', "%$query%")
                        ->orWhere('titre', 'LIKE', "%$query%")
                        ->orWhere('description', 'LIKE', "%$query%")
                        ->orWhere('lieu', 'LIKE', "%$query%")
                        ->orWhere('heure_debut', 'LIKE', "%$query%")
                        ->orWhere('heure_fin', 'LIKE', "%$query%")
                        ->orWhere('type_evenement', 'LIKE', "%$query%")
                        ->orWhere('organisateur', 'LIKE', "%$query%")
                        ->paginate(1);

        return view('events.index', compact('events'));
    }

    // AFFICHAGE DE L'ÉVÉNEMENT
    public function index()
    {
        // Récupération de la liste des événements
        $events = Event::paginate(5);

        return view('events.index', compact('events'));
    }

    // PAGE POUR LA CRÉATION DE L'ÉVÉNEMENT
    public function create()
    {
        // Action réservée uniquement à un leader
        if (Auth::check() && !Auth::user()->roles->contains('name', 'leader')) {
            return redirect()->route('events.index')->with('error', "Vous n'êtes pas autorisé à accéder à cette page.");        
        }    

        $events = Event::paginate(5);
        $organizers = Organizer::all();
        $locations = Location::all();
        $themes = Theme::all();

        return view('events.create', compact('events', 'organizers', 'locations', 'themes'));
    }

    // CRÉATION DE L'ÉVÉNEMENT
    public function store(Request $request)
    {
        // Seul leader a le droit de créer l'événement
        if (Auth::check() && !Auth::user()->roles->contains('name', 'leader')) {
            return redirect()->route('events.index')->with('error', "Vous n'êtes pas autorisé à accéder à cette page.");        
        }

        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'typeEvent' => 'required',
        ]);

        // Récupérer 1 ou plusieurs id (organizer_id) à partir du formulaire
        $organizerIds = $request->input('organizers_id');

        // Récupérer theme_id à partir de la requête
        $themeId = $request->input('theme_id');

        // Récupérer location_id à partir de la requête
        $locationId = $request->input('location_id');

        // Créer un nouvel événement et associer les organisateurs correspondants
        $event = new Event();
        $event->title = $validatedData['title'];
        $event->description = $validatedData['description'];
        $event->start_date = $validatedData['startDate'];
        $event->end_date = $validatedData['endDate'];
        $event->type = $validatedData['typeEvent'];
        $event->location_id = $locationId;
        $event->theme_id = $themeId;
        $event->save();

        // Attacher les organisateurs sélectionnés à l'événement
        $event->organizers()->attach($organizerIds);

        // La session récupère et affiche le message flash dans une boîte d'alerte
        session()->flash('success', 'Événement créé avec succès');

        return redirect()->route('events.index'); // = return redirect('events');
    }

    // VUE GLOBAL DE L'ÉVÉNEMENT
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    // PAGE DE MODIFICATION DE L'ÉVÉNEMENT
    public function edit(Event $event)
    {
        // Seul leader a le droit de modifier cet événement
        if (Auth::check() && !Auth::user()->roles->contains('name', 'leader')) {
            return redirect()->route('events.index')->with('error', "Vous n'êtes pas autorisé à accéder à cette page.");        
        }

        $organizers = Organizer::all();
        $locations = Location::all();

        return view('events.edit', compact('event', 'organizers', 'locations'));
    }

    // MODIFICATION DE L'ÉVÉNEMENT
    public function update(Request $request, Event $event)
    {
        // Seul leader a le droit de modifier cet événement
        if (Auth::check() && !Auth::user()->roles->contains('name', 'leader')) {
            return redirect()->route('events.index')->with('error', "Vous n'êtes pas autorisé modifier cet événement.");        
        }

        $validatedData = $request->validate([
            'theme' => 'required',
            'title' => 'required',
            'description' => 'required',
            'location_id' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:start_date',
            'typeEvent' => 'required',
        ]);

        $event->update($validatedData);

        // Récupérer 1 ou plusieurs identifiants (organizer_id) à partir du formulaire
        $organizerIds = $request->input('organizers_id');

        // Attacher les organisateurs sélectionnés à l'événement
        $event->organizers()->sync($organizerIds);

        // La session récupère et affiche le message flash dans une boîte d'alerte
        session()->flash('success', 'Événement mis à jour avec succès');

        return redirect()->route('events.index');
    }

    // SUPPRESSION DE L'ÉVÉNEMENT
    public function destroy(Event $event)
    {
        // Seul leader a le droit de supprimer cet'événement
        if (Auth::check() && !Auth::user()->roles->contains('name', 'leader')) {
            return redirect()->route('events.index')->with('error', "Vous n'êtes pas autorisé à supprimer cet événement.");        
        }

        $event->delete();

        // La session récupère et affiche le message flash dans une boîte d'alerte
        session()->flash('success', 'Événement supprimé avec succès');

        return redirect()->route('events.index');
    }
}
