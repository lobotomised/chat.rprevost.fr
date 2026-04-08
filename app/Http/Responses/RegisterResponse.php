<?php

namespace App\Http\Responses;

use App\Models\Conversation;
use App\Models\InviteLink;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        $token = $request->session()->pull('invite_token');

        if (! $token) {
            return redirect(config('fortify.home', '/'));
        }

        $link = InviteLink::where('token', $token)->first();

        if (! $link || ! $link->user) {
            return redirect(config('fortify.home', '/'));
        }

        $conversation = Conversation::getOrCreateDirect($link->user, $request->user());

        return redirect()->route('conversations.show', $conversation);
    }
}
