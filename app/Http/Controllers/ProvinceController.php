<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        $query = Province::query();
        // Inputs
        $search = $request->input('search');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        $page = $request->input('page', 0);
        $perPage = $request->input('per_page', 20);

        // Search
        if ($request->has('search')) {
            $columns = Schema::getColumnListing((new Province)->getTable());
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

        $province = Province::create($request);

        return $province;
    }

    public function show(Province $province)
    {
        return $province;
    }

    public function update(Request $request, Province $province)
    {
        $request = $request->validate([
            'pageid' => 'required',
        ]);

        $province->update($request);

        return $province;
    }

    public function destroy(Province $province)
    {
        $province->delete();

        return [
            'message' => 'Province deleted successfully'
        ];
    }
}
