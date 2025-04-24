<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Collection::query();
        // Inputs
        $search = $request->input('search');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        $page = $request->input('page', 0);
        $perPage = $request->input('per_page', 20);

        // Search
        if ($request->has('search')) {
            $columns = Schema::getColumnListing((new Collection)->getTable());
            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        // Sorting
        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }
        $query->orderBy($sort, $order);

        // Pagination
        $collections = $query->paginate($perPage, ['*'], 'page', $page + 1);

        // Response
        return response()->json([
            'per_page' => $collections->perPage(),
            'total' => $collections->total(),
            'data' => $collections->items(),
        ]);
    }

    public function store(Request $request)
    {
        $request = $request->validate([
            'title' => 'required',
            'handle' => 'required',
            'description' => 'required'
        ]);

        $collection = Collection::create($request);

        return $collection;
    }

    public function show(Collection $collection)
    {
        return $collection;
    }

    public function update(Request $request, Collection $collection)
    {
        $request = $request->validate([
            'title' => 'required',
            'handle' => 'required',
            'description' => 'required'
        ]);

        $collection->update($request);

        return $collection;
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();

        return [
            'message' => 'Collection deleted successfully'
        ];
    }
}
