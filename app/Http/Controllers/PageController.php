<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();
        // Inputs
        $search = $request->input('search');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        $page = $request->input('page', 0);
        $perPage = $request->input('per_page', 20);
        $town = $request->input('town');
        $province = $request->input('province');

        // Search
        if ($request->has('search')) {
            $columns = Schema::getColumnListing((new Page)->getTable());
            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        // Filters
        if ($request->filled('town')) {
            $query->where('town', $town);
        }
        if ($request->filled('province')) {
            $query->where('province', $province);
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
            'name' => 'required',
            'town' => 'required',
            'province' => 'required'
        ]);

        $page = Page::create($request);

        return $page;
    }

    public function show(Page $page)
    {
        return $page;
    }

    public function update(Request $request, Page $page)
    {
        $request = $request->validate([
            'name' => 'required',
            'town' => 'required',
            'province' => 'required'
        ]);

        $page->update($request);

        return $page;
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return [
            'message' => 'Page deleted successfully'
        ];
    }
}
