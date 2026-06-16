<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Actions\Action;

class Login extends BaseLogin
{
    public function getHeading(): \Illuminate\Contracts\Support\Htmlable|string
    {
        return '';
    }

    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
            Action::make('back')
                ->label('← Kembali ke halaman utama')
                ->url('/')
                ->color('gray'),
        ];
    }
}