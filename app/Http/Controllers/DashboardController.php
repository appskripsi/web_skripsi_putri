<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $student = Auth::guard('student')->user();

        $newest_book = Book::query()
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // s: Fuzzy Mamdani
        $books_query = Book::with(['category'])
            ->select([
                'id',
                'name',
                'author',
                'image',
                'stock',
                'borrowed',
                'level',
                'category_id',
                'academic_id',
                'created_at'
            ]);

        if (!empty($student)) {
            $books_query->where('academic_id', $student->academic_id);
        }

        $books = $books_query->get();

        $recommendations = $books->map(function ($book) {
            // Hitung Rata-rata Nilai Rating
            $average_rating = $book->calculateAvgRating() ?? 0;

            // Fuzzifikasi
            $total_loan = $this->fuzzifyTotalBookLoan($book->borrowed);
            $rating = $this->fuzzifyBookRating($average_rating);
            $level = $this->fuzzifyBookLevel($book->level);

            $recomendation_score = $this->inferensi($total_loan, $rating, $level);

            return [
                'id' => $book->id,
                'name' => $book->name,
                'author' => $book->author,
                'image' => $book->image,
                'category' => $book->category->name,
                'level' => $book->level,
                'score' => $recomendation_score,
                'created_at' => $book->created_at
            ];
        });

        // Sorting hasil rekomendasi berdasarkan score
        $recommendations = $recommendations->sortByDesc('score')
            ->take(8)
            ->shuffle();

        return view('dashboard', compact(['newest_book', 'recommendations']));
    }

    // Labelling Total Buku Dipinjam
    private function fuzzifyTotalBookLoan($total): string
    {
        if ($total <= 5)
            return 'Sedikit';
        if ($total <= 15)
            return 'Sedang';
        return 'Banyak';
    }

    // Labelling Total Rating Buku
    private function fuzzifyBookRating($rating): string
    {
        if ($rating <= 2)
            return 'Rendah';
        if ($rating <= 4)
            return 'Sedang';
        return 'Tinggi';
    }

    // Labelling Tingkat Kesulitan Buku
    private function fuzzifyBookLevel($level): string
    {
        switch ($level) {
            case 1:
                return 'Mudah';
            case 2:
                return 'Sedang';
            case 3:
                return 'Sulit';
            default:
                return 'Tidak Diketahui';
        }
    }

    // Fuzzy Mamdani Inferensi
    private function inferensi($total_book_loan, $book_rating, $book_level)
    {
        $rules = [
            'Sedikit,Rendah,Mudah' => 1,
            'Sedikit,Rendah,Sedang' => 2,
            'Sedikit,Rendah,Sulit' => 2,
            'Sedikit,Sedang,Mudah' => 2,
            'Sedikit,Sedang,Sedang' => 3,
            'Sedikit,Sedang,Sulit' => 3,
            'Sedikit,Tinggi,Mudah' => 3,
            'Sedikit,Tinggi,Sedang' => 4,
            'Sedikit,Tinggi,Sulit' => 4,
            'Sedang,Rendah,Mudah' => 2,
            'Sedang,Rendah,Sedang' => 3,
            'Sedang,Rendah,Sulit' => 3,
            'Sedang,Sedang,Mudah' => 3,
            'Sedang,Sedang,Sedang' => 4,
            'Sedang,Sedang,Sulit' => 4,
            'Sedang,Tinggi,Mudah' => 4,
            'Sedang,Tinggi,Sedang' => 5,
            'Sedang,Tinggi,Sulit' => 5,
            'Banyak,Rendah,Mudah' => 3,
            'Banyak,Rendah,Sedang' => 3,
            'Banyak,Rendah,Sulit' => 3,
            'Banyak,Sedang,Mudah' => 4,
            'Banyak,Sedang,Sedang' => 4,
            'Banyak,Sedang,Sulit' => 4,
            'Banyak,Tinggi,Mudah' => 5,
            'Banyak,Tinggi,Sedang' => 5,
            'Banyak,Tinggi,Sulit' => 5,
        ];

        $key = "{$total_book_loan},{$book_rating},{$book_level}";

        return $rules[$key] ?? 1;
    }
}
