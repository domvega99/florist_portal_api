<?php

namespace App\Http\Controllers;

use App\Models\Florist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class FloristController extends Controller
{
    public function index(Request $request)
    {
        $query = Florist::query();
        // Inputs
        $search = $request->input('search');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        $page = $request->input('page', 0);
        $perPage = $request->input('per_page', 20);
        $status = $request->input('status');
        $city = $request->input('city');
        $floristRep = $request->input('florist_rep');


        // Search
        if ($request->has('search')) {
            $columns = Schema::getColumnListing((new Florist)->getTable());
            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $status);
        }
        if ($request->filled('city')) {
            $query->where('city', $city);
        }
        if ($request->filled('florist_rep')) {
            $query->where('florist_rep', $floristRep);
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
            'florist_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);

        $florist = Florist::create($request);

        return $florist;
    }

    public function show(Florist $florist)
    {
        return $florist;
    }

    public function update(Request $request, Florist $florist)
    {
        $request = $request->validate([
            'florist_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);

        $florist->update($request);

        return $florist;
    }

    public function destroy(Florist $florist)
    {
        $florist->delete();

        return [
            'message' => 'Florist deleted successfully'
        ];
    }
}
