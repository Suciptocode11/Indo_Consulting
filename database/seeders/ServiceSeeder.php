<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title'   => 'Bisnis & Manajemen SDM',
                'short'   => 'Solusi komprehensif untuk pengembangan sumber daya manusia meliputi rekrutmen, pelatihan, dan manajemen kinerja.',
                'content' => 'Solusi komprehensif untuk pengembangan sumber daya manusia meliputi rekrutmen, pelatihan, dan manajemen kinerja organisasi.',
                'icon'    => 'groups',
                'img'     => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJFJscYh7O0kxSXjZlMyZuqxWqdUpYYCu1sVrD-G0Jw-iNN6VqOAACQ1cui_xjtTV8XvuAWWiKxOqhkT4BVC6S0wRZQGI5PO0k3EkIHypoA7YYT0l-sZD8TfGWo2nS1s3biW5_HOFUU5MgClto_rwZ3eWXYQwAvBMg8z0s_gUbEdMrk5x7x-VKsL02lWws4-WgqVGH-_aq2LCSNiaxPOTQfiaHbI_ORTl_56lCbCNu52JqqvWvzRut3x_70dOGU4NewkEkF96koQ',
                'status'  => 'Show',
                'slug'    => 'bisnis-manajemen-sdm',
                'url'     => null,
            ],
            [
                'title'   => 'Training & Education Management',
                'short'   => 'Program pelatihan terstruktur dan manajemen pendidikan untuk peningkatan kapasitas organisasi dan individu.',
                'content' => 'Program pelatihan terstruktur dan manajemen pendidikan untuk peningkatan kapasitas organisasi dan individu.',
                'icon'    => 'school',
                'img'     => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDNT-AkjbnMfp1iL7a50LwvMbkD5C-L1Zw9UZP3GVenS4tcze1sW5k0AyHVxNkLDqx6pHIkemvJoniLonC6y_W1IvRzXVq3L60WwPrkOJymw9GBsHu8lruhlrI7qlqIQdfr2tv82nj4UK_9gbs47Y1vjDwHtLhX2Hqc4DOE8RqFVPEOhfgFrH2f5eebeerdpG46Dj0ZVGGM3DdDFVS3WVoZf9NH_OB2n4L16-6Xlb4OWVB2wbeVzqkdCJOsd5pBnSuFw9D15iw-aA',
                'status'  => 'Show',
                'slug'    => 'training-education-management',
                'url'     => null,
            ],
            [
                'title'   => 'Keuangan dan Investasi',
                'short'   => 'Analisis keuangan mendalam dan strategi investasi untuk pertumbuhan jangka panjang.',
                'content' => 'Analisis keuangan mendalam dan strategi investasi untuk pertumbuhan jangka panjang.',
                'icon'    => 'account_balance',
                'img'     => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDEW_2T4MsL-YvRBkIhcTWNqWaIaRJIuRLBbaH_vIxZ1A5hPbSlCDNo83Iqmzi2osHSVx3golBBt_wPDHNT_wkaogzviGs3zIhbiHLfbz1nDphhuWeNupRGHalHC32R96wA9koYrxe5shoKsXKT7AqZ-c6GutlUynzEd7rebXQRLZfV_uZMV0MgF0kdER69PoelqwAekPtXaJMr7zSSjR-OPHRC8sM7nhNwuLosrow-G2KJu_ElMx_lyBIgsMcYd8nXZNjpq22qLQ',
                'status'  => 'Show',
                'slug'    => 'keuangan-dan-investasi',
                'url'     => null,
            ],
            [
                'title'   => 'Hukum dan Perizinan',
                'short'   => 'Layanan hukum bisnis komprehensif mulai dari penyusunan kontrak hingga kepatuhan regulasi.',
                'content' => 'Layanan hukum bisnis komprehensif mulai dari penyusunan kontrak hingga kepatuhan regulasi.',
                'icon'    => 'gavel',
                'img'     => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAL1Yrgw4nq9aYZs5mpN96O5EowIhVEYGXiEjT7Ol2MA-N8y-cAgpwBsaCbC8X_QrzaWaMKg69MQMVNj_yWNO-qrDvWpVsT1x7HWTMrB7BHnYBejlVZFjaYc4lhUy9PF0o-g9kEJYPsNwJef0ii-EM_Rq8_xQ2q-xEOD4OFuD1dqth9rv-qqM7z0EbQFrhBOKo2JcF3mudl80oxKinL5guECviPyVgTzjXVlJN73hq7F3uhxgEMNaiE7902ybb3zSGiKuw8jJ8NnQ',
                'status'  => 'Show',
                'slug'    => 'hukum-dan-perizinan',
                'url'     => null,
            ],
        ];

        foreach ($services as $service) {
            DB::table('service')->insert($service);
        }
    }
}
