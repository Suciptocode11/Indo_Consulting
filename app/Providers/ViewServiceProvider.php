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

        // Share pending counters ke admin layout
        View::composer('admin.layouts.app', function ($view) {
            $view->with([
                'pendingPendaftaranCount' => \App\Models\Pendaftaran::where('status', 'Pending')->count(),
                'pendingPartnerCount'     => \App\Models\PartnerSubmission::where('status', 'Pending')->count(),
            ]);
        });
    }
}
