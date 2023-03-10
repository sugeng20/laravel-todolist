<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => 'sugeng'
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'sugeng',
            'password' => 'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'sugeng');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            'user' => 'sugeng'
        ])->post('/login', [
            'user' => 'sugeng',
            'password' => 'rahasia'
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText('User or password is required');
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => 'sihem',
            'password' => 'qwe'
        ])->assertSeeText('User or Password wrong');
    }

    public function testLogout()
    {
        $this->withSession(['user' => 'sugeng'])
                ->post('/logout')
                ->assertRedirect('/')
                ->assertSessionMissing('user');   
    }

    public function testGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}
