<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->createDummyImage('projects', 'portfolio-1.jpg', 'Pengembangan SDM BUMN', 0, 102, 180);
        $this->createDummyImage('projects', 'portfolio-2.jpg', 'Manajemen Keuangan', 0, 153, 76);
        $this->createDummyImage('projects', 'portfolio-3.jpg', 'Strategi Bisnis', 204, 102, 0);
        $this->createDummyImage('projects', 'portfolio-4.jpg', 'Training Pendidikan', 0, 51, 102);
        $this->createDummyImage('projects', 'portfolio-5.jpg', 'Konsultasi Hukum', 102, 0, 51);

        $projects = [
            ['title' => 'Program Pengembangan Kompetensi SDM PT PLN (Persero)', 'slug' => 'pengembangan-kompetensi-sdm-pln', 'content' => 'Implementasi program pengembangan kompetensi SDM secara menyeluruh untuk 500+ pegawai PT PLN (Persero) meliputi assessment, pelatihan teknis, dan coaching individu. Program ini berhasil meningkatkan kompetensi pegawai sebesar 40% dalam 12 bulan.', 'lokasi' => 'Jakarta Selatan', 'img' => 'projects/portfolio-1.jpg', 'status' => 'Show', 'date' => '2026-01-15', 'hit' => 120],
            ['title' => 'Restrukturisasi Keuangan PT Semen Indonesia', 'slug' => 'restrukturisasi-keuangan-semen-indonesia', 'content' => 'Analisis mendalam dan restrukturisasi laporan keuangan korporat guna meningkatkan efisiensi operasional dan profitabilitas. Termasuk optimasi cash flow, perencanaan pajak strategis, dan implementasi sistem kontrol keuangan baru.', 'lokasi' => 'Gresik, Jawa Timur', 'img' => 'projects/portfolio-2.jpg', 'status' => 'Show', 'date' => '2026-02-20', 'hit' => 95],
            ['title' => 'Strategi Ekspansi Pasar PT Telkom Indonesia', 'slug' => 'strategi-ekspansi-pasar-telkom', 'content' => 'Pengembangan strategi ekspansi pasar digital untuk regional Asia Tenggara meliputi analisis kompetitor, riset pasar, dan rencana aksi 3 tahun. Strategi ini berhasil membuka 3 pasar baru.', 'lokasi' => 'Bandung, Jawa Barat', 'img' => 'projects/portfolio-3.jpg', 'status' => 'Show', 'date' => '2026-03-10', 'hit' => 88],
            ['title' => 'Manajemen Training Angkatan Pemprov DKI Jakarta', 'slug' => 'manajemen-training-pemprov-dki', 'content' => 'Perancangan dan pelaksanaan program training bagi 200+ pegawai negeri sipil Pemprov DKI Jakarta meliputi leadership, public speaking, dan tata kelola pemerintahan yang baik.', 'lokasi' => 'Jakarta Pusat', 'img' => 'projects/portfolio-4.jpg', 'status' => 'Show', 'date' => '2026-04-05', 'hit' => 75],
            ['title' => 'Konsultasi Legal & Perizinan PT Freeport Indonesia', 'slug' => 'konsultasi-legal-freeport', 'content' => 'Pendampingan hukum dan pengurusan perizinan operasional pertambangan di Papua. Meliputi analisis risiko regulasi, negosiasi kontrak, dan kepatuhan terhadap peraturan lingkungan hidup.', 'lokasi' => 'Timika, Papua', 'img' => 'projects/portfolio-5.jpg', 'status' => 'Show', 'date' => '2026-05-12', 'hit' => 110],
        ];

        foreach ($projects as $p) {
            DB::table('project')->updateOrInsert(
                ['slug' => $p['slug']],
                $p
            );
        }

        // Blog categories (use existing ones)
        $this->createDummyImage('blog', 'news-1.jpg', 'Workshop SDM', 0, 102, 153);
        $this->createDummyImage('blog', 'news-2.jpg', 'Seminar Keuangan', 153, 51, 0);
        $this->createDummyImage('blog', 'news-3.jpg', 'Pelatihan Kepemimpinan', 51, 0, 102);
        $this->createDummyImage('blog', 'news-4.jpg', 'Konferensi Hukum', 0, 102, 51);
        $this->createDummyImage('blog', 'news-5.jpg', 'Webinar Bisnis', 102, 51, 102);

        $blogs = [
            ['title' => 'Workshop Manajemen Sumber Daya Manusia Modern', 'slug' => 'workshop-manajemen-sdm-modern', 'caption' => 'Workshop intensif 3 hari tentang strategi SDM modern', 'content' => '<p>Indo Consulting menyelenggarakan workshop manajemen SDM modern yang dihadiri oleh 50+ HR Director dari berbagai BUMN dan perusahaan swasta terkemuka. Workshop ini membahas tren terbaru dalam pengelolaan talent, performance management berbasis data, dan employee experience.</p><p>Peserta mendapatkan toolkit praktis yang langsung dapat diterapkan di organisasi masing-masing.</p>', 'tags' => 'SDM, Workshop, HR, Manajemen', 'img' => 'blog/news-1.jpg', 'status' => 'Show', 'date' => '2026-06-01', 'hit' => 234, 'id_category' => 1],
            ['title' => 'Seminar Nasional Strategi Keuangan Korporat', 'slug' => 'seminar-nasional-strategi-keuangan', 'caption' => 'Update strategi keuangan untuk menghadapi tantangan 2026', 'content' => '<p>Seminar nasional yang menghadirkan pembicara dari Bank Indonesia, OJK, dan praktisi keuangan senior. Topik yang dibahas meliputi strategi pengelolaan likuiditas, optimasi struktur modal, dan implementasi green finance.</p><p>Acara ini dihadiri oleh 200+ peserta dari sektor perbankan dan keuangan.</p>', 'tags' => 'Keuangan, Seminar, Korporat', 'img' => 'blog/news-2.jpg', 'status' => 'Show', 'date' => '2026-06-15', 'hit' => 189, 'id_category' => 3],
            ['title' => 'Pelatihan Kepemimpinan Transformasional', 'slug' => 'pelatihan-kepemimpinan-transformasional', 'caption' => 'Membangun pemimpin masa depan yang adaptif dan inovatif', 'content' => '<p>Program pelatihan kepemimpinan berbasis experiential learning selama 5 hari. Peserta mengalami simulasi bisnis, outdoor challenge, dan coaching session一对一 dengan certified executive coach.</p><p>Tingkat kepuasan peserta mencapai 98% dengan rencana tindak lanjut personal untuk setiap peserta.</p>', 'tags' => 'Kepemimpinan, Training, Leadership', 'img' => 'blog/news-3.jpg', 'status' => 'Show', 'date' => '2026-07-01', 'hit' => 156, 'id_category' => 2],
            ['title' => 'Konferensi Hukum Bisnis & Regulasi Terbaru', 'slug' => 'konferensi-hukum-bisnis-regulasi', 'caption' => 'Pembaruan regulasi bisnis dan dampaknya bagi korporasi', 'content' => '<p>Konferensi tahunan yang membahas perkembangan regulasi bisnis terbaru di Indonesia, termasuk UU Cipta Kerja, peraturan data pribadi, dan kepatuhan anti pencucian uang.</p><p>Pembicara dari Kementerian Hukum, Kejaksaan Agung, dan partner firma hukum terkemuka.</p>', 'tags' => 'Hukum, Regulasi, Compliance', 'img' => 'blog/news-4.jpg', 'status' => 'Show', 'date' => '2026-07-10', 'hit' => 142, 'id_category' => 4],
            ['title' => 'Webinar Strategi Digitalisasi Bisnis UKM', 'slug' => 'webinar-strategi-digitalisasi-ukm', 'caption' => 'Roadmap transformasi digital untuk usaha kecil dan menengah', 'content' => '<p>Webinar gratis yang dihadiri oleh 500+ pelaku UKM dari seluruh Indonesia. Materi mencakup strategi digital marketing, implementasi ERP sederhana, dan optimasi supply chain berbasis teknologi.</p><p>Webinar ini merupakan bagian dari program Corporate Social Responsibility Indo Consulting untuk mendukung pertumbuhan UKM nasional.</p>', 'tags' => 'Digital, UKM, Transformasi', 'img' => 'blog/news-5.jpg', 'status' => 'Show', 'date' => '2026-07-20', 'hit' => 312, 'id_category' => 1],
        ];

        foreach ($blogs as $b) {
            DB::table('blog')->updateOrInsert(
                ['slug' => $b['slug']],
                $b
            );
        }

        $this->command->info('Dummy data created: 5 projects + 5 blog posts with images.');
    }

    private function createDummyImage(string $dir, string $filename, string $label, int $r, int $g, int $b): void
    {
        $path = storage_path("app/public/{$dir}");
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $fullPath = "{$path}/{$filename}";
        if (file_exists($fullPath)) {
            return;
        }

        // Download from picsum.photos as placeholder
        $seed = crc32($filename);
        $url = "https://picsum.photos/seed/{$seed}/800/500";
        $ctx = stream_context_create(['http' => ['timeout' => 10]]);
        $data = @file_get_contents($url, false, $ctx);

        if ($data !== false) {
            file_put_contents($fullPath, $data);
        } else {
            // Fallback: create a minimal 1x1 PNG (will show as tiny image)
            $this->createMinimalPng($fullPath, $r, $g, $b);
        }
    }

    private function createMinimalPng(string $path, int $r, int $g, int $b): void
    {
        // Create a minimal valid PNG with a single colored pixel
        $header = pack('C8', 137, 80, 78, 71, 13, 10, 26, 10);

        // IHDR chunk
        $ihdrData = pack('NNccccc', 1, 1, 8, 2, 0, 0, 0);
        $ihdrCrc = pack('N', crc32('IHDR' . $ihdrData));
        $ihdr = pack('N', 13) . 'IHDR' . $ihdrData . $ihdrCrc;

        // IDAT chunk
        $raw = chr(0) . chr($r) . chr($g) . chr($b);
        $compressed = gzcompress($raw);
        $idatCrc = pack('N', crc32('IDAT' . $compressed));
        $idat = pack('N', strlen($compressed)) . 'IDAT' . $compressed . $idatCrc;

        // IEND chunk
        $iendCrc = pack('N', crc32('IEND'));
        $iend = pack('N', 0) . 'IEND' . $iendCrc;

        file_put_contents($path, $header . $ihdr . $idat . $iend);
    }
}