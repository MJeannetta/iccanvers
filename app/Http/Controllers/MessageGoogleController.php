<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;

class MessageGoogleController extends Controller
{
    // VOIR LE FORMULAIRE DE CONTACT
    public function formContactGoogle()
    {
        return view('form-contact');
    }

    // ENVOYER LE MESSAGE DU FORMULAIRE DE CONTACT
    public function sendMessageGoogle(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];

        try {
            // Envoie le message par e-mail
            Mail::to('djezlaravel@gmail.com')->send(new ContactMessage($data));

            // Retourne la vue de contact avec un message de succès
            session()->flash('success', 'Votre message a été envoyé avec succès!');

            // Redirige vers la même page (page de formulaire de contact).
            return back();
    
        } catch (exception $th) {
            
            return response()->json(['Désolé quelque chose s\'est mal passée.']);
        }
    }
}
