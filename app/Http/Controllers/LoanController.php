<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookLoanRequest;
use App\Models\Book;
use App\Models\BookLoan;
use App\Models\BookRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class LoanController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $student = Auth::guard('student')->user();

        if ($request->ajax()) {
            $loans = BookLoan::with(['book', 'student'])
                ->where('student_id', $student->id);

            return DataTables::of($loans)
                ->addIndexColumn()
                ->escapeColumns()
                ->addColumn('rating', function ($data) {
                    $exist = BookRating::where('book_id', $data->book_id)
                        ->where('student_id', $data->student_id)
                        ->exists();

                    if (!$exist && $data->status == BookLoan::completed_status) {
                        return true;
                    }

                    return false;
                })
                ->toJson();
        }

        return view('history.index');
    }

    public function create(Request $request): View|RedirectResponse
    {
        $student = Auth::guard('student')->user();

        $book_id = $request->query('id');

        if (!$book_id) {
            return redirect()->route('dashboard');
        }

        $exist = BookLoan::where('student_id', $student->id)
            ->where('status', BookLoan::pending_status)
            ->where('book_id', $book_id)
            ->first();

        $is_exist = false;

        if ($exist) {
            $is_exist = true;
        }

        $book = Book::where('id', $book_id)->first();

        return view('book.loan', compact(['student', 'book', 'is_exist']));
    }

    public function store(BookLoanRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['student_id'] = Auth::guard('student')->user()->id;
        $validated['status'] = BookLoan::pending_status;

        if (BookLoan::create($validated)) {
            return redirect()->route('loan.index')->with('success', 'Berhasil Meminjam Buku');
        }

        return redirect()->route('book.index')->with('error', 'Gagal meminjam buku');
    }
}
