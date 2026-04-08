<?php

namespace App\Http\Responses;

use App\Models\Conversation;
use App\Models\InviteLink;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $token = $request->session()->pull('invite_token');

        if (! $token) {
            return redirect()->intended(config('fortify.home', '/'));
        }

        $link = InviteLink::where('token', $token)->first();

        if (! $link || ! $link->user) {
            return redirect()->intended(config('fortify.home', '/'));
        }

        $conversation = Conversation::getOrCreateDirect($link->user, $request->user());

        return redirect()->route('conversations.show', $conversation);
    }
}
