<?php

namespace App\Providers;

use App\Models\Pengaturan;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share data global ke SEMUA view
        View::composer('*', function ($view) {
            $view->with([
                'pengaturan'   => Pengaturan::first(),
                'socialMedia'  => SocialMedia::orderBy('urutan')->get(),
            ]);
        });
    }
}
