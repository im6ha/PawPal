<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
        'adoption' => \App\Models\Adoption::class,
        'products' => \App\Models\Product::class,
        'sitters'  => \App\Models\Sitter::class,
        'lost-pets' => \App\Models\LostPet::class,
    ]);
    }



}