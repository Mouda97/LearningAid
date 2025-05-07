protected $listen = [
    \Illuminate\Auth\Events\Login::class => [
        \App\Listeners\LogSuccessfulLogin::class,
    ],
    // Autres événements...
];