<?php

namespace App\Http\Controllers;

use App\Models\InviteLink;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    public function __invoke(Request $request, InviteLink $link)
    {
        if (! $link->user) {
            abort(404);
        }

        if (Auth::check()) {
            $conversation = Conversation::getOrCreateDirect($link->user, $request->user());

            return redirect()->route('conversations.show', $conversation);
        }

        // Sinon : on garde l’invite en session et on passe par login
        $request->session()->put('invite_token', $link->token);

        return redirect()->route('login');
    }

}
