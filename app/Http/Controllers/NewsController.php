<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show(News $news)
    {
        // Increment views
        $news->increment('views');
        
        // Get related news (same category)
        $relatedNews = News::where('category', $news->category)
            ->where('id', '!=', $news->id)
            ->published()
            ->latestNews(3)
            ->get();
        
        return view('front.news.show', compact('news', 'relatedNews'));
    }
}