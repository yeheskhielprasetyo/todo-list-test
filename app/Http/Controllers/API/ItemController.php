<?php

namespace App\Http\Controllers\API;

use App\Models\Item;
use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($checklistId)
    {
        $checklist = Checklist::where('user_id', auth()->id())->findOrFail($checklistId);
        $items = $checklist->items;
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Get All Checklist Item',
            'data' => $items
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
    public function store(Request $request, $checklistId)
    {
        $validator = Validator::make($request->all(), [
            'itemName' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 400);
        }

        $checklist = Checklist::where('user_id', auth()->id())->findOrFail($checklistId);

        $item = Item::create([
            'itemName' => $request->itemName,
            'checklist_id' => $checklist->id
        ]);

        return response()->json([
            'code' => 201,
            'status' => 'success',
            'message' => 'Item created successfully',
            'data' => $item
        ], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show($checklistId, $itemId)
    {
        $item = Item::whereHas('checklist', function ($query) use ($checklistId) {
            $query->where('id', $checklistId)->where('user_id', auth()->id());
        })->findOrFail($itemId);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $item
        ], 200);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($checklistId, $itemId)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $checklistId, $itemId)
    {
        $validator = Validator::make($request->all(), [
            'itemName' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 400);
        }

        $item = Item::whereHas('checklist', function ($query) use ($checklistId) {
            $query->where('id', $checklistId)->where('user_id', auth()->id());
        })->findOrFail($itemId);

        $item->itemName = $request->itemName;
        $item->save();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Item updated successfully',
            'data' => $item
        ], 200);
    }
    
    /**
     * Update status of the specified checklist item.
     */
    public function updateStatus(Request $request, $checklistId, $itemId)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 400);
        }

        $item = Item::whereHas('checklist', function ($query) use ($checklistId) {
            $query->where('id', $checklistId)->where('user_id', auth()->id());
        })->findOrFail($itemId);

        $item->status = $request->status;
        $item->save();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Item status updated successfully',
            'data' => $item
        ], 200);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($checklistId, $itemId)
    {
        $item = Item::whereHas('checklist', function ($query) use ($checklistId) {
            $query->where('id', $checklistId)->where('user_id', auth()->id());
        })->findOrFail($itemId);

        $item->delete();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Item deleted successfully'
        ], 200);
    }
    
    /**
     * Rename the specified checklist item.
     */
    public function rename(Request $request, $checklistId, $itemId)
    {
        $validator = Validator::make($request->all(), [
            'itemName' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 400);
        }

        $item = Item::whereHas('checklist', function ($query) use ($checklistId) {
            $query->where('id', $checklistId)->where('user_id', auth()->id());
        })->findOrFail($itemId);

        $item->itemName = $request->itemName;
        $item->save();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Item renamed successfully',
            'data' => $item
        ], 200);
    }
}
