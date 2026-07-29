<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        // Insert pengaturan (singleton — 1 baris)
        DB::table('pengaturan')->insert([
            'id'        => 1,
            'company'   => 'Indo Consulting',
            'address'   => 'Jl. Ganetri IV No.4, Tonja, Kec. Denpasar Utara, Kota Denpasar, Bali 80237',
            'phone'     => '+62 878-653-09966',
            'email'     => 'partner@indoconsulting.id',
            'website'   => 'https://indoconsulting.id',
            'copyright' => '&copy; ' . date('Y') . ' Indo Consulting. Hak cipta dilindungi.',
        ]);

        // Insert social media
        $socials = [
            ['id' => 1, 'platform' => 'instagram', 'url' => '', 'label' => 'Instagram', 'urutan' => 0, 'status' => 1],
            ['id' => 2, 'platform' => 'youtube', 'url' => '', 'label' => 'YouTube', 'urutan' => 1, 'status' => 1],
            ['id' => 3, 'platform' => 'whatsapp', 'url' => '', 'label' => 'WhatsApp', 'urutan' => 2, 'status' => 1],
        ];

        foreach ($socials as $s) {
            DB::table('social_media')->insert($s);
        }

        // Insert page contents — Home page
        $homeContents = [
            ['page' => 'home', 'key' => 'hero_heading_1', 'value' => 'Bergerak', 'type' => 'text'],
            ['page' => 'home', 'key' => 'hero_heading_2', 'value' => 'Bertumbuh', 'type' => 'text'],
            ['page' => 'home', 'key' => 'hero_heading_3', 'value' => 'Bersama', 'type' => 'text'],
            ['page' => 'home', 'key' => 'hero_description', 'value' => 'Indo Consulting adalah lembaga konsultan terkemuka bidang Manajemen Pendidikan, Pengembangan SDM, Keuangan, Teknologi Informasi, serta Hukum dan Perizinan.', 'type' => 'textarea'],
            ['page' => 'home', 'key' => 'hero_badge', 'value' => 'Terpercaya', 'type' => 'text'],
            ['page' => 'home', 'key' => 'hero_badge_sub', 'value' => 'Sejak 2009', 'type' => 'text'],
            ['page' => 'home', 'key' => 'hero_btn_primary', 'value' => 'Konsultasi Sekarang', 'type' => 'text'],
            ['page' => 'home', 'key' => 'hero_btn_secondary', 'value' => 'Pelajari Lebih Lanjut', 'type' => 'text'],
            ['page' => 'home', 'key' => 'stats_1_number', 'value' => '17', 'type' => 'text'],
            ['page' => 'home', 'key' => 'stats_1_label', 'value' => 'Tahun Pengalaman', 'type' => 'text'],
            ['page' => 'home', 'key' => 'stats_2_number', 'value' => '127', 'type' => 'text'],
            ['page' => 'home', 'key' => 'stats_2_label', 'value' => 'Klien Puas', 'type' => 'text'],
            ['page' => 'home', 'key' => 'stats_3_number', 'value' => '538', 'type' => 'text'],
            ['page' => 'home', 'key' => 'stats_3_label', 'value' => 'Proyek Selesai', 'type' => 'text'],
            ['page' => 'home', 'key' => 'programs_heading', 'value' => 'Program Kami', 'type' => 'text'],
            ['page' => 'home', 'key' => 'programs_description', 'value' => 'Layanan konsultasi terintegrasi untuk berbagai kebutuhan bisnis Anda', 'type' => 'text'],
            ['page' => 'home', 'key' => 'about_heading', 'value' => 'Tentang Indo Consulting', 'type' => 'text'],
            ['page' => 'home', 'key' => 'about_badge', 'value' => '15+ Tahun', 'type' => 'text'],
            ['page' => 'home', 'key' => 'about_badge_sub', 'value' => 'Melayani klien terbaik', 'type' => 'text'],
            ['page' => 'home', 'key' => 'portfolio_heading', 'value' => 'Portfolio Kami', 'type' => 'text'],
            ['page' => 'home', 'key' => 'portfolio_description', 'value' => 'Karya nyata yang membawa dampak bagi klien kami', 'type' => 'text'],
            ['page' => 'home', 'key' => 'partners_heading', 'value' => 'Mitra & Klien Kami', 'type' => 'text'],
            ['page' => 'home', 'key' => 'news_heading', 'value' => 'Berita & Acara', 'type' => 'text'],
            ['page' => 'home', 'key' => 'news_description', 'value' => 'Informasi terkini seputar kegiatan Indo Consulting', 'type' => 'text'],
            ['page' => 'home', 'key' => 'testimonial_heading', 'value' => 'Apa Kata Klien Kami', 'type' => 'text'],
            ['page' => 'home', 'key' => 'testimonial_description', 'value' => 'Kepercayaan dan kepuasan klien adalah standar terbaik kami', 'type' => 'text'],
            ['page' => 'home', 'key' => 'cta_heading', 'value' => 'Siap untuk Bertumbuh Bersama Kami?', 'type' => 'text'],
            ['page' => 'home', 'key' => 'cta_description', 'value' => 'Hubungi tim konsultan kami dan temukan solusi terbaik untuk bisnis Anda.', 'type' => 'text'],
        ];

        // Tentang Kami page
        $tentangContents = [
            ['page' => 'tentang-kami', 'key' => 'page_label', 'value' => 'Tentang Kami', 'type' => 'text'],
            ['page' => 'tentang-kami', 'key' => 'page_heading', 'value' => 'Mitra Strategis untuk Bisnis yang Berkelanjutan', 'type' => 'text'],
            ['page' => 'tentang-kami', 'key' => 'stats_1_number', 'value' => '17', 'type' => 'text'],
            ['page' => 'tentang-kami', 'key' => 'stats_1_label', 'value' => 'Tahun Pengalaman', 'type' => 'text'],
            ['page' => 'tentang-kami', 'key' => 'stats_2_number', 'value' => '127', 'type' => 'text'],
            ['page' => 'tentang-kami', 'key' => 'stats_2_label', 'value' => 'Klien Puas', 'type' => 'text'],
            ['page' => 'tentang-kami', 'key' => 'stats_3_number', 'value' => '538', 'type' => 'text'],
            ['page' => 'tentang-kami', 'key' => 'stats_3_label', 'value' => 'Proyek Selesai', 'type' => 'text'],
            ['page' => 'tentang-kami', 'key' => 'cta_heading', 'value' => 'Siap bertumbuh bersama kami?', 'type' => 'text'],
            ['page' => 'tentang-kami', 'key' => 'cta_description', 'value' => 'Konsultasikan kebutuhan bisnis Anda dengan tim ahli kami.', 'type' => 'text'],
        ];

        // Program page
        $programContents = [
            ['page' => 'program', 'key' => 'page_label', 'value' => 'Layanan Kami', 'type' => 'text'],
            ['page' => 'program', 'key' => 'page_heading', 'value' => 'Program Konsultasi', 'type' => 'text'],
            ['page' => 'program', 'key' => 'page_description', 'value' => 'Layanan terintegrasi yang dirancang untuk memenuhi kebutuhan bisnis modern.', 'type' => 'text'],
            ['page' => 'program', 'key' => 'cta_heading', 'value' => 'Butuh konsultasi program?', 'type' => 'text'],
            ['page' => 'program', 'key' => 'cta_description', 'value' => 'Tim ahli kami siap membantu menentukan solusi yang tepat.', 'type' => 'text'],
        ];

        // Portfolio page
        $portfolioContents = [
            ['page' => 'portfolio', 'key' => 'page_label', 'value' => 'Karya Kami', 'type' => 'text'],
            ['page' => 'portfolio', 'key' => 'page_heading', 'value' => 'Portfolio', 'type' => 'text'],
            ['page' => 'portfolio', 'key' => 'cta_heading', 'value' => 'Ingin hasil seperti ini?', 'type' => 'text'],
            ['page' => 'portfolio', 'key' => 'cta_description', 'value' => 'Tim kami siap merancang solusi yang tepat sasaran untuk bisnis Anda.', 'type' => 'text'],
        ];

        // Kontak page
        $kontakContents = [
            ['page' => 'kontak-kami', 'key' => 'page_heading', 'value' => 'Mari Berdiskusi', 'type' => 'text'],
            ['page' => 'kontak-kami', 'key' => 'page_description', 'value' => 'Apakah Anda memiliki pertanyaan tentang layanan kami, atau ingin memulai sesi konsultasi pertama? Jangan ragu untuk menghubungi kami.', 'type' => 'textarea'],
            ['page' => 'kontak-kami', 'key' => 'faq_heading', 'value' => 'Pertanyaan yang Sering Diajukan', 'type' => 'text'],
        ];

        // Partners page
        $partnersContents = [
            ['page' => 'partners-clients', 'key' => 'page_label', 'value' => 'Kepercayaan Klien', 'type' => 'text'],
            ['page' => 'partners-clients', 'key' => 'page_heading', 'value' => 'Partners & Clients', 'type' => 'text'],
        ];

        // News page
        $newsContents = [
            ['page' => 'news-events', 'key' => 'page_label', 'value' => 'Informasi Terkini', 'type' => 'text'],
            ['page' => 'news-events', 'key' => 'page_heading', 'value' => 'News & Events', 'type' => 'text'],
        ];

        // Gallery page
        $galleryContents = [
            ['page' => 'gallery', 'key' => 'page_label', 'value' => 'Dokumentasi', 'type' => 'text'],
            ['page' => 'gallery', 'key' => 'page_heading', 'value' => 'Gallery', 'type' => 'text'],
        ];

        // Expert page
        $expertContents = [
            ['page' => 'our-expert', 'key' => 'page_label', 'value' => 'Tim Profesional', 'type' => 'text'],
            ['page' => 'our-expert', 'key' => 'page_heading', 'value' => 'Our Expert', 'type' => 'text'],
            ['page' => 'our-expert', 'key' => 'cta_heading', 'value' => 'Ingin bergabung dengan tim kami?', 'type' => 'text'],
            ['page' => 'our-expert', 'key' => 'cta_description', 'value' => 'Kami selalu mencari talenta terbaik untuk bergabung bersama Indo Consulting.', 'type' => 'text'],
        ];

        $allContents = array_merge(
            $homeContents,
            $tentangContents,
            $programContents,
            $portfolioContents,
            $kontakContents,
            $partnersContents,
            $newsContents,
            $galleryContents,
            $expertContents
        );

        foreach ($allContents as $content) {
            DB::table('page_contents')->insert($content);
        }
    }
}
