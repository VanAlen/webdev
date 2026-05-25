<?php
// src/EventListener/SessionListener.php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class SessionListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        
        $request = $event->getRequest();
        $host = $request->getHttpHost(); // Gets host with port
        
        // Debug output (remove in production)
        // error_log("SessionListener: Setting cookie domain for host: " . $host);
        
        // Set cookie domain based on current host
        if (str_contains($host, 'ngrok-free.dev')) {
            // For ngrok URLs like abc123.ngrok-free.dev
            ini_set('session.cookie_domain', '.ngrok-free.dev');
        } elseif (str_contains($host, '127.0.0.1') || str_contains($host, 'localhost')) {
            // For local development
            ini_set('session.cookie_domain', '127.0.0.1');
        }
        // For production domains, leave as default
    }
}