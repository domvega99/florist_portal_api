<?php

namespace App\Http\Controllers;

use App\Models\Florist;
use App\Http\Controllers\Controller;
use App\Models\FloristInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $floristRep = $request->input('floristrep');
        // Joins
        $query->leftJoin('status', 'status.id', '=', 'florists.status')
            ->leftJoin('towns', 'towns.id', '=', 'florists.city')
            ->leftJoin('users', 'users.id', '=', 'florists.floristrep')
            ->leftJoin('province', 'province.id', '=', 'florists.province');
        // Search
        $columns = Schema::getColumnListing((new Florist)->getTable());
        $query->where(function ($q) use ($columns, $search) {
            foreach ($columns as $column) {
                $q->orWhere("florists.$column", 'like', '%' . $search . '%');
            }
        });

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $status);
        }
        if ($request->filled('city')) {
            $query->where('city', $city);
        }
        if ($request->filled('floristrep')) {
            $query->where('floristrep', $floristRep);
        }
        if ($request->filled('province')) {  
            $query->where('province', $province);
        }
        // Sorting
        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }
        $query->orderBy($sort, $order);
        // Select fields
        $query->select([
            'florists.*',
            'towns.name as city_name',
            'province.name as province_name',
            'status.statusname as status_name',
            'users.username as floristrep_name',
        ]);
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
        $validated = $request->validate([
            'status' => 'required',
            'floristname' => 'required',
            'contactnumber' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'call_outcome' => 'required',
            'social_media' => 'required',
            'product_type' => 'required',
            'product_price' => 'required|numeric',
            'delivery_fee' => 'required|numeric',
            'sell_extras' => 'required',
            'popularity_trend' => 'nullable|string|max:255',
            'preferred_communication' => 'nullable|string|max:255',
            'website' => 'required',
            'province' => 'required',
            'member_of_other_networks' => 'nullable',
            'flower_supplier' => 'nullable|string|max:255',
            'interested_in_free_website' => 'nullable',
            'florist_rep' => 'required',
            'additional_info' => 'nullable|string|max:1000',
            'floristcode' => 'required',
            'shopify_gid' => 'required',
            'florist_info' => 'required',
            'collection' => 'required',
            'imported' => 'required',
            'info_id' => 'required',
            'user' => 'required',
            'discount_offer' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'meta_description' => 'nullable|string|max:1000',
            'page_title' => 'nullable|string|max:255',
        ]);

        // Start database transaction
        DB::beginTransaction();

        try {
            // Create the FloristInfo record
            $floristInfo = FloristInfo::create([
                'call_outcome' => $validated['call_outcome'],
                'product_type' => $validated['product_type'],
                'product_price' => $validated['product_price'],
                'delivery_fee' => $validated['delivery_fee'],
                'sell_extras' => $validated['sell_extras'],
                'popularity_trend' => $validated['popularity_trend'],
                'preferred_communication' => $validated['preferred_communication'],
                'member_of_other_networks' => $validated['member_of_other_networks'],
                'flower_supplier' => $validated['flower_supplier'],
                'interested_in_free_website' => $validated['interested_in_free_website'],
                'discount_offer' => $validated['discount_offer'],
                'additional_info' => $validated['additional_info'],
                'description' => $validated['description'],
                'meta_description' => $validated['meta_description'],
                'page_title' => $validated['page_title'],
            ]);

            $florist = Florist::create([
                'floristcode' => $validated['floristcode'],
                'status' => $validated['status'],
                'floristname' => $validated['floristname'],
                'contactnumber' => $validated['contactnumber'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'infoid' => $floristInfo->id, 
            ]);

            // Commit the transaction
            DB::commit();

            // Return the created florist
            return response()->json($florist, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while creating the florist.',
                'message' => $e->getMessage(),
                'details' => $e->getTrace(),
            ], 500);
        }
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
