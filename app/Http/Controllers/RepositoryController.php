<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use App\Models\Repository;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RepositoryController extends Controller
{
    public function index(Request $request): View
    {
        $academics = Academic::query()
            ->select('id', 'name')
            ->where('status', 1)
            ->get();

        $types = Type::query()
            ->select('id', 'name')
            ->where('status', 1)
            ->get();

        $per_page = $request->query('per_page', 10);

        $repositories = Repository::with(['student', 'type', 'academic'])
            ->when(request('date'), function ($query, $date) {
                $query->orderBy('created_at', $date == 'newest' ? 'desc' : 'asc');
            })
            ->when(request('type'), function ($query, $type) {
                $query->where('type_id', $type);
            })
            ->when(request('academic'), function ($query, $academic) {
                $query->where('academic_id', $academic);
            })
            ->when(request('search'), function ($query, $search) {
                $query->where('title', 'like', "%$search%");
            })
            ->paginate($per_page);

        return view(
            'repository.index',
            compact(['academics', 'types', 'repositories'])
        );
    }

    public function show(Repository $repository): View
    {
        $repository->load(['student', 'type', 'academic']);
        
        return view('repository.detail', compact('repository'));
    }
}
