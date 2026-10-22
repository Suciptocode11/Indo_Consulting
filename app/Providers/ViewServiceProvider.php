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
            $pengaturan = Pengaturan::first();
            $waPhone = $pengaturan?->whatsapp_number ?? '6287865309966';
            $waUrl = $pengaturan?->whatsapp_url ?? ('https://wa.me/' . $waPhone . '?text=' . rawurlencode('Halo Indo Consulting, saya ingin konsultasi.'));

            $view->with([
                'pengaturan'   => $pengaturan,
                'socialMedia'  => SocialMedia::orderBy('urutan')->get(),
                'waPhone'      => $waPhone,
                'waUrl'        => $waUrl,
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
