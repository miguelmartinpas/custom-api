<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomApiTest extends TestCase {

    protected $prefix = '/custom-api';
    protected $route = '/search';

    public function testCallWithoutQParamShouldReturn400(){
        $response = $this->get($this->prefix.$this->route);
        $response->assertStatus(400);
    }

    public function testCallWithQParamShouldReturn200(){
        $response = $this->get($this->prefix.$this->route.'?q=Deadpool');
        $response->assertStatus(200);
    }

    public function testCallWithQParamShouldReturn200AndData(){
        $response = $this->get($this->prefix.$this->route.'?q=Deadpool');
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Deadpool']);
    }

    public function testCallWithQParamShouldReturn200AndEmtyData(){
        $response = $this->get($this->prefix.$this->route.'?q=qwertyqwerty');
        $response->assertStatus(200);
        $response->assertJson([]);
    }

}
