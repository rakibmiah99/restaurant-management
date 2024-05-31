<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['auth.check' => \App\Http\Middleware\AuthMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Exception $exception){
            dd($exception->getTrace()) ;
        });


        $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response){
           if($response->getStatusCode() == 404){
               return response()->view('404');
           }
           else if($response->getStatusCode() == 500){
               return response()->view('500');
           }
        });
    })->create();
