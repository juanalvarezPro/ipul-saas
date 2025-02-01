<?php

namespace App\Listeners;

use App\Mail\NewDeviceLoginMail;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class NotifyOnNewDeviceLogin
{
    /**
     * Create the event listener.
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        $ip = request()->ip(); // Obtener la IP del usuario
        $userAgent = request()->header('User-Agent'); // Obtener el User-Agent del navegador

        $lastSession = DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('user_agent', $userAgent)
            ->first();

        // Si no hay una sesión previa, no se genera un logoutUrl
        if ($lastSession) {
            $logoutUrl = URL::temporarySignedRoute(
                'logout.session',
                now()->addMinutes(30),
                ['session_id' => $lastSession->id]
            );

            Mail::to($user->email)->send(new NewDeviceLoginMail($ip, $userAgent, $logoutUrl));
        }

            
    }
}
