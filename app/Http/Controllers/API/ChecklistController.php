<?php

namespace App\Http\Controllers\API;

use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checklists = auth()->user()->checklists;
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Get All Data Checklist',
            'data' => auth()->user()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 400);
        }

        $checklist = Checklist::create([
            'name' => $request->name,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'code' => 201,
            'status' => 'success',
            'message' => 'Checklist created successfully',
            'data' => $checklist
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $checklist = Checklist::where('user_id', auth()->id())->findOrFail($id);
        $checklist->delete();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Checklist deleted successfully'
        ], 200);
    }
}
