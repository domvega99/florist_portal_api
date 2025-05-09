<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TownController extends Controller
{
    public function index(Request $request)
    {
        $query = Town::query();
        // Inputs
        $search = $request->input('search');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        $page = $request->input('page', 0);
        $perPage = $request->input('per_page', 20);

        // Search
        if ($request->has('search')) {
            $columns = Schema::getColumnListing((new Town)->getTable());
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
        $tasks = $query->paginate($perPage, ['*'], 'page', $page + 1);

        // Response
        return response()->json([
            'per_page' => $tasks->perPage(),
            'total' => $tasks->total(),
            'data' => $tasks->items(),
        ]);
    }

    public function store(Request $request)
    {
        $request = $request->validate([
            'pageid' => 'required',
        ]);

        $town = Town::create($request);

        return $town;
    }

    public function show(Town $town)
    {
        return $town;
    }

    public function update(Request $request, Town $town)
    {
        $request = $request->validate([
            'pageid' => 'required',
        ]);

        $town->update($request);

        return $town;
    }

    public function destroy(Town $town)
    {
        $town->delete();

        return [
            'message' => 'Town deleted successfully'
        ];
    }
}
