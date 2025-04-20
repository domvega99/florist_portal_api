<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        // Inputs
        $search = $request->input('search');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        $page = $request->input('page', 0);
        $perPage = $request->input('per_page', 20);

        // Search
        if ($request->has('search')) {
            $columns = Schema::getColumnListing((new User())->getTable());
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
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($data);

        $token = $user->createToken($request->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $request = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users'
        ]);

        $user->update($request);

        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();

        return [
            'message' => 'User deleted successfully'
        ];
    }

}
