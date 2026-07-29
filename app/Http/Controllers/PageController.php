<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use App\Models\Service;
use App\Models\Project;
use App\Models\Client;
use App\Models\Blog;
use App\Models\Review;
use App\Models\Member;
use App\Models\Album;
use App\Models\Foto;
use App\Models\Video;
use App\Models\Faq;
use App\Models\Keunggulan;
use App\Models\VisiMisi;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'services'         => Service::where('status', 'Show')->get(),
            'projects'         => Project::where('status', 'Show')->with('kategoriProject')->limit(5)->get(),
            'clients'          => Client::where('status', 'Show')->get(),
            'blogs'            => Blog::where('status', 'Show')->with('kategori')->latest('date')->limit(3)->get(),
            'reviews'          => Review::where('status', 'Show')->get(),
            'pageContent'      => PageContent::getPage('home'),
        ]);
    }

    public function tentangKami()
    {
        return view('pages.tentang-kami', [
            'visiMisi'    => VisiMisi::where('status', 'Show')->orderBy('urutan')->get(),
            'keunggulan'  => Keunggulan::where('status', 'Show')->orderBy('urutan')->get(),
            'pageContent' => PageContent::getPage('tentang-kami'),
        ]);
    }

    public function program()
    {
        return view('pages.program', [
            'services'    => Service::where('status', 'Show')->get(),
            'pageContent' => PageContent::getPage('program'),
        ]);
    }

    public function portfolio()
    {
        return view('pages.portfolio', [
            'projects'    => Project::where('status', 'Show')->with(['kategoriProject', 'service'])->get(),
            'kategoris'   => \App\Models\KategoriProject::all(),
            'pageContent' => PageContent::getPage('portfolio'),
        ]);
    }

    public function partnersClients()
    {
        return view('pages.partners-clients', [
            'clients'     => Client::where('status', 'Show')->get(),
            'reviews'     => Review::where('status', 'Show')->get(),
            'pageContent' => PageContent::getPage('partners-clients'),
        ]);
    }

    public function newsEvents()
    {
        $blogs = Blog::where('status', 'Show')->with('kategori')->latest('date')->get();

        return view('pages.news-events', [
            'blogs'       => $blogs,
            'categories'  => $blogs->pluck('kategori.title')->filter()->unique()->values(),
            'pageContent' => PageContent::getPage('news-events'),
        ]);
    }

    public function gallery()
    {
        return view('pages.gallery', [
            'albums'           => Album::where('status', 'Show')->with('photos')->get(),
            'standalonePhotos' => Foto::whereNull('id_album')->get(),
            'videos'           => Video::where('status', 'Show')->get(),
            'pageContent'      => PageContent::getPage('gallery'),
        ]);
    }

    public function ourExpert()
    {
        return view('pages.our-expert', [
            'members'     => Member::where('status', 'Show')->get(),
            'pageContent' => PageContent::getPage('our-expert'),
        ]);
    }

    public function karir()
    {
        return view('pages.karir');
    }

    public function kontakKami()
    {
        return view('pages.kontak-kami', [
            'faqs'        => Faq::where('status', 'Show')->orderBy('urutan')->orderBy('id')->get(),
            'pageContent' => PageContent::getPage('kontak-kami'),
        ]);
    }

    public function programShow($slug)
    {
        $program = Service::where('slug', $slug)->where('status', 'Show')->firstOrFail();

        // Program lain untuk section "Program Lainnya"
        $otherPrograms = Service::where('status', 'Show')
            ->where('id', '!=', $program->id)
            ->limit(3)
            ->get();

        return view('pages.program-show', [
            'program'       => $program,
            'otherPrograms' => $otherPrograms,
            'pageContent'   => PageContent::getPage('program'),
        ]);
    }

    public function blogShow($slug)
    {
        $blog = Blog::where('slug', $slug)->where('status', 'Show')->firstOrFail();

        // Auto-increment view counter
        $blog->increment('hit');

        // Berita lain
        $otherBlogs = Blog::where('status', 'Show')
            ->where('id', '!=', $blog->id)
            ->with('kategori')
            ->latest('date')
            ->limit(3)
            ->get();

        return view('pages.blog-show', [
            'blog'       => $blog,
            'otherBlogs' => $otherBlogs,
        ]);
    }

    public function portfolioShow($slug)
    {
        $project = Project::where('slug', $slug)
            ->where('status', 'Show')
            ->with(['kategoriProject', 'service', 'photos'])
            ->firstOrFail();

        // Auto-increment hit counter if available
        if (isset($project->hit)) {
            $project->increment('hit');
        }

        // Other projects for "Proyek Lainnya" section
        $otherProjects = Project::where('status', 'Show')
            ->where('id', '!=', $project->id)
            ->with('kategoriProject')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        return view('pages.portfolio-show', [
            'project'       => $project,
            'otherProjects' => $otherProjects,
            'pageContent'   => PageContent::getPage('portfolio'),
        ]);
    }
}
