<?php

namespace App\Http\Services\Todo;

use App\Models\Todo;
use Illuminate\Support\Collection;

class TodoService
{
    public function getAll(): Collection
    {
        return Todo::all();
    }

    public function create(Collection $collect): void
    {
        Todo::create([
            'title' => $collect->get('title'),
            'status' => $collect->get('status'),
        ]);
    }

    public function getById($id): Collection
    {
        return collect(Todo::findOrFail($id));
    }

    public function edit($id, $collect): Todo
    {
        $todo = Todo::findOrFail($id);
        $todo->update($collect->toArray());
        return $todo;
    }

    public function delete($id): void
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
    }
}
