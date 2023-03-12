<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            'user' => 'sugeng',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'oke'
                ],
                [
                    'id' => '2',
                    'todo' => 'sip'
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('oke')
            ->assertSeeText('2')
            ->assertSeeText('sip');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'sugeng'
        ])->post('/todolist', [])
            ->assertSeeText('Todo is required');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            'user' => 'sugeng'
        ])->post('/todolist', [
            'todo' => 'sip'
        ])->assertRedirect('/todolist');
    }

    public function testRemoveTodo()
    {
        $this->withSession([
            'user' => 'sugeng',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'oke'
                ],
                [
                    'id' => '2',
                    'todo' => 'sip'
                ]
            ]
        ])->post('/todolist/1/delete')
        ->assertRedirect('/todolist');
    }
}
