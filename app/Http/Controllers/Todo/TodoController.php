<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\CreateTodoRequest;
use App\Http\Services\Todo\TodoService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function __construct(
        private readonly TodoService $todoService
    ) {}

    public function index(): JsonResponse
    {
        $data = $this->todoService->getAll();
        return response()->json($data);
    }

    public function store(CreateTodoRequest $request): JsonResponse
    {
        $collect = $request->collect();
        $this->todoService->create($collect);
        return response()->json([
            'status' => 'success',
            'message' => 'successfully created'
        ]);
    }

    public function show($id): JsonResponse
    {
        try {
            $data = $this->todoService->getById($id);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $collect = $request->collect();
            $data = $this->todoService->edit($id, $collect);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->todoService->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'successfully deleted'
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
