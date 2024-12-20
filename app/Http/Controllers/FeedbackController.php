<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function index(): View
    {
        return view('feedback.index');
    }

    public function store(FeedbackRequest $reqeust): RedirectResponse
    {
        $validated = $reqeust->validated();

        if (Feedback::create($validated)) {
            return redirect()->route('feedback.index');
        }

        return redirect()->route('feedback.index')->with(
            'error',
            'Gagal mengirimkan masukan dan saran. Silahkan coba kembali.'
        );
    }
}
