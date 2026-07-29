<?php
$file = file_get_contents('C:/Laravel/projects/Indo_Consulting/resources/views/pages/home.blade.php');

// Replace hardcoded news array
$newsOld = '@php
            $news = [
                [';
$newsNew = '@php
            $news = \App\Models\Blog::where(\'status\', \'Show\')->with(\'kategori\')->latest(\'date\')->limit(3)->get();
            $newsItems = $news->values();
        @endphp';

// Find and replace the news block
$pattern = '/@php\s*\$news\s*=\s*\[[\s\S]*?\];\s*@endphp/';
$file = preg_replace($pattern, $newsNew, $file);

// Replace hardcoded testimonials array
$testPattern = '/@php\s*\$homeTestimonials\s*=\s*\[[\s\S]*?\];\s*@endphp/';
$testNew = '@php
            $homeTestimonials = \App\Models\Review::where(\'status\', \'Show\')->get();
        @endphp';
$file = preg_replace($testPattern, $testNew, $file);

file_put_contents('C:/Laravel/projects/Indo_Consulting/resources/views/pages/home.blade.php', $file);
echo "Done";
