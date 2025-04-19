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
        $province = $request->input('province');
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

    public function getCities()
    {
        $cities = Florist::select('city')
            ->distinct()
            ->orderBy('city', 'asc')
            ->pluck('city');

        foreach ($cities as $key => $city) {
            $cities[$key] = [
                'city' => $city ?? ''
            ];
        }

        return response()->json($cities);
    }


    public function getProvinces()
    {
        $provinces = Florist::select('province')
            ->distinct()
            ->orderBy('province', 'asc')
            ->pluck('province');

        foreach ($provinces as $key => $province) {
            $provinces[$key] = [
                'province' => $province ?? ''
            ];
        }

        return response()->json($provinces);
    }

    public function getStatuses()
    {
        $statuses = Florist::select('status')
            ->distinct()
            ->orderBy('status', 'asc')
            ->pluck('status');

        foreach ($statuses as $key => $status) {
            if (!empty($status)) {
                $statuses[$key] = [
                    'status' => $status
                ];
            }
        }

        return response()->json($statuses);
    }

    public function getFloristReps()
    {
        $florist_reps = Florist::select('florist_rep')
            ->distinct()
            ->orderBy('florist_rep', 'asc')
            ->pluck('florist_rep');

        $filtered_reps = [];

        foreach ($florist_reps as $florist_rep) {
            if (!empty($florist_rep)) {
                $filtered_reps[] = [
                    'florist_rep' => $florist_rep
                ];
            }
        }

        return response()->json($filtered_reps);
    }
}
