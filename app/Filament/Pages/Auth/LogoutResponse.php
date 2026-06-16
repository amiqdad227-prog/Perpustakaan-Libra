<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Http\Responses\LogoutResponse as BaseLogoutResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LogoutResponse extends BaseLogoutResponse
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        return redirect('/');
    }
}