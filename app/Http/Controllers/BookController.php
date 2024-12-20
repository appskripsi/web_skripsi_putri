<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $academics = Academic::query()
            ->select('id', 'name')
            ->where('status', 1)
            ->get();

        $categories = Category::query()
            ->select('id', 'name')
            ->get();

        $per_page = $request->input('per_page', 10);

        $books = Book::with('loans')
            ->withCount([
                'loans as loan_count' => function ($query) {
                    $query->where('status', BookLoan::approved_status);
                }
            ])
            ->withAvg('ratings', 'rating')
            ->when(request('date'), function ($query, $date) {
                $query->orderBy('created_at', $date == 'newest' ? 'desc' : 'asc');
            })
            ->when(request('category'), function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when(request('academic'), function ($query, $academic) {
                $query->where('academic_id', $academic);
            })
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%$search%");
            })
            ->paginate($per_page);

        return view(
            'book.index',
            compact(['academics', 'categories', 'books'])
        );
    }

    public function show(Book $book): View
    {
        $book->load([
            'category',
            'academic',
            'ratings' => function ($query) {
                $query->with('student')
                    ->orderBy('created_at', 'desc')
                    ->limit(10);
            }
        ]);

        $book->withCount([
            'loans as loan_count' => function ($query) {
                $query->where('status', BookLoan::completed_status);
            }
        ]);

        $rating = round($book->ratings()->avg('rating'), 1);

        return view(
            'book.detail',
            compact(['book', 'rating'])
        );
    }
}
