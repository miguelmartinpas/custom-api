<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomApiTest extends TestCase {

    protected $prefix = '/custom-api';

    public function testCallWithoutQParamShouldReturn400(){
        $response = $this->get($this->prefix.'/resource');
        $response->assertStatus(400);
    }

    public function testCallWithQParamShouldReturn200(){
        $response = $this->get($this->prefix.'/resource?q=Deadpool');
        $response->assertStatus(200);
    }

    public function testCallWithQParamShouldReturn200AndData(){
        $response = $this->get($this->prefix.'/resource?q=Deadpool');
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Deadpool']);
    }

    public function testCallWithQParamShouldReturn200AndEmtyData(){
        $response = $this->get($this->prefix.'/resource?q=asdfasdf');
        $response->assertStatus(200);
        $response->assertJsonFragment(['error' => 'Search without results for "asdfasdf"']);
    }

}
