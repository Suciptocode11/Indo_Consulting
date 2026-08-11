<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $baseUrl = config('app.url', 'https://indoconsulting.id');

        $pages = [
            ['url' => '/', 'priority' => '1.0', 'freq' => 'weekly'],
            ['url' => '/tentang-kami', 'priority' => '0.8', 'freq' => 'monthly'],
            ['url' => '/program', 'priority' => '0.9', 'freq' => 'weekly'],
            ['url' => '/portfolio', 'priority' => '0.9', 'freq' => 'weekly'],
            ['url' => '/news-events', 'priority' => '0.8', 'freq' => 'daily'],
            ['url' => '/gallery', 'priority' => '0.7', 'freq' => 'monthly'],
            ['url' => '/partners-clients', 'priority' => '0.7', 'freq' => 'monthly'],
            ['url' => '/our-expert', 'priority' => '0.7', 'freq' => 'monthly'],
            ['url' => '/kontak-kami', 'priority' => '0.8', 'freq' => 'monthly'],
            ['url' => '/karir', 'priority' => '0.7', 'freq' => 'monthly'],
        ];

        $services = Service::where('status', 'Show')->select('slug', 'updated_at')->get();
        $blogs = Blog::where('status', 'Show')->select('slug', 'updated_at')->get();
        $projects = Project::where('status', 'Show')->select('slug', 'updated_at')->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($pages as $page) {
            $xml .= $this->urlEntry($baseUrl . $page['url'], $page['priority'], $page['freq']);
        }

        foreach ($services as $s) {
            $xml .= $this->urlEntry($baseUrl . '/program/' . $s->slug, '0.7', 'monthly', $s->updated_at);
        }

        foreach ($blogs as $b) {
            $xml .= $this->urlEntry($baseUrl . '/berita/' . $b->slug, '0.6', 'monthly', $b->updated_at);
        }

        foreach ($projects as $p) {
            $xml .= $this->urlEntry($baseUrl . '/portfolio/' . $p->slug, '0.6', 'monthly', $p->updated_at);
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function urlEntry(string $loc, string $priority, string $freq, $lastmod = null): string
    {
        $xml = "  <url>\n";
        $xml .= "    <loc>{$loc}</loc>\n";
        if ($lastmod) {
            $xml .= "    <lastmod>" . \Carbon\Carbon::parse($lastmod)->toDateString() . "</lastmod>\n";
        }
        $xml .= "    <changefreq>{$freq}</changefreq>\n";
        $xml .= "    <priority>{$priority}</priority>\n";
        $xml .= "  </url>\n";
        return $xml;
    }
}
