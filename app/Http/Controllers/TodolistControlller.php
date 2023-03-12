<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\Request;

class TodolistControlller extends Controller
{
    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService) {
        $this->todolistService = $todolistService;
    }
    public function todolist(Request $request)
    {
        $todolist = $this->todolistService->getTodolist();
        return response()->view('todolist.todolist', [
            'title' => 'Todolist',
            'todolist' => $todolist
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input('todo');

        if(empty($todo)) {
            $todolist = $this->todolistService->getTodolist();
            return response()->view('todolist.todolist', [
                'title' => 'Todolist',
                'todolist' => $todolist,
                'error' => 'Todo is required'
            ]);
        }

        $this->todolistService->saveTodo(uniqid(), $todo);
        return redirect()->action([TodolistControlller::class, 'todolist']);
    }

    public function removeTodo(Request $request, $todoId)
    {
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistControlller::class, 'todolist']);
    }
}
