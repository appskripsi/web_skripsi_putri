<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $newest_book = Book::query()
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('dashboard', compact('newest_book'));
    }
}
