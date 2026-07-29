<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Blog;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Member;
use App\Models\Project;
use App\Models\Review;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index', [
            'stats' => [
                'services' => Service::count(),
                'projects' => Project::count(),
                'clients' => Client::count(),
                'blogs' => Blog::count(),
                'reviews' => Review::count(),
                'members' => Member::count(),
                'faqs' => Faq::count(),
                'albums' => Album::count(),
            ],
        ]);
    }
}
