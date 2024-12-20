<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodolistResource;
use App\Models\Logging;
use App\Models\Todolist;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodolistController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $latest_todolists = Todolist::latest()->where("user_id", auth()->user()->id)->get();

            Log::info("Fetch todolist successfully.");

            return response()->json([
                "message" => "Fetch todolist successfully.",
                "data" => TodolistResource::collection($latest_todolists)
            ], 200);
        } catch (Exception $err) {
            $msg = "Failed to fetch todolist with error: " . $err->getMessage();
            Log::error($msg);
            Logging::record_logging(auth()->user()->id, $msg);
            return response()->json([
                "message" => $msg
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Set Policy
        $this->authorize("create", Todolist::class);

        $request_validate = $request->validate([
            "user_id" => "exists:users,id",
            "title" => "required|min:3|max:100",
            "description" => "required|min:3|max:200",
            "is_done" => "required|in:0,1"
        ]);

        try {
            $request_validate["user_id"] = auth()->user()->id;
            $todo = Todolist::create($request_validate);

            Log::info("Todo created successfully.");

            return response()->json([
                "message" => "Todo created successfully.",
                "data" => new TodolistResource($todo)
            ], 201);
        } catch (Exception $err) {
            $msg = "Failed to create todo with error: " . $err->getMessage();
            Log::error($msg);
            Logging::record_logging(auth()->user()->id, $msg);
            return response()->json([
                "message" => $msg
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todo = Todolist::find($id);

        if (!$todo) {
            $msg = "Todo with id $id not found.";
            Logging::record_logging(auth()->user()->id, $msg);
            return response()->json([
                "message" => $msg
            ], 404);
        }

        // Set Policy
        $this->authorize("view", $todo);

        Log::info("Fetch todo successfully.");

        return response()->json([
            "message" => "Fetch todo successfully.",
            "data" => new TodolistResource($todo)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $todo = Todolist::find($id);

        $request_validate = $request->validate([
            "title" => "required|min:3|max:100",
            "description" => "required|min:3|max:200",
            "is_done" => "required|in:0,1"
        ]);

        if (!$todo) {
            $msg = "Todo with id $id not found.";
            Logging::record_logging(auth()->user()->id, $msg);
            return response()->json([
                "message" => $msg
            ], 404);
        }

        // Set Policy
        $this->authorize("update", $todo);

        try {
            $todo->update($request_validate);

            Log::info("Todo updated successfully.");

            return response()->json([
                "message" => "Todo updated successfully.",
                "data" => new TodolistResource($todo)
            ], 200);
        } catch (Exception $err) {
            $msg = "Failed to update todo with error: " . $err->getMessage();
            Log::error($msg);
            Logging::record_logging(auth()->user()->id, $msg);
            return response()->json([
                "message" => $msg
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todolist::find($id);

        if (!$todo) {
            $msg = "Todo with id $id not found.";
            Logging::record_logging(auth()->user()->id, $msg);
            return response()->json([
                "message" => $msg
            ], 404);
        }

        // Set Policy
        $this->authorize("delete", $todo);

        try {
            $todo->delete();

            Log::info("Todo with id $id deleted successfully.");

            return response()->json([
                "message" => "Todo with id $id deleted successfully."
            ], 200);
        } catch (Exception $err) {
            $msg = "Failed to delete todo with error: " . $err->getMessage();
            Log::error($msg);
            Logging::record_logging(auth()->user()->id, $msg);
            return response()->json([
                "message" => $msg
            ], 500);
        }
    }
}
