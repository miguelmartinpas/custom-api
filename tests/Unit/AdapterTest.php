<?php

namespace Tests\Unit;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use CustomApi\Services\ShowAdapter;

class AdapterTest extends TestCase {

    protected $validQuery = "Superman";
    protected $invalidQuery = "qwertyqwerty";

    public function testSearchWithNullParameterWithoutCache(){
        Cache::flush();
        $showAdapter = new ShowAdapter();
        $shows = $showAdapter->query(null)->search()->shows();
        $this->assertTrue($shows->isEmpty());
    }

    public function testSearchWithNullParameterWithCache(){
        $showAdapter = new ShowAdapter();
        $shows = $showAdapter->query(null)->search()->shows();
        $this->assertTrue($shows->isEmpty());
    }

    public function testSearchWithInvalidParameterWithoutCache(){
        Cache::flush();
        $showAdapter = new ShowAdapter();
        $shows = $showAdapter->query($this->invalidQuery)->search()->shows();
        $this->assertTrue($shows->isEmpty());
    }

    public function testSearchWithInvalidParameterWithCache(){
        $showAdapter = new ShowAdapter();
        $shows = $showAdapter->query($this->invalidQuery)->search()->shows();
        $this->assertTrue($shows->isEmpty());
    }

    public function testSearchWithValidParameterWithoutCache(){
        Cache::flush();
        $showAdapter = new ShowAdapter();
        $shows = $showAdapter->query($this->validQuery)->search()->shows();
        $this->assertTrue($shows->isNotEmpty());
        $this->assertEquals($shows->count(), 10);
        $this->assertEquals($shows->first()->name, 'Superman');
    }

    public function testSearchWithValidParameterWithCache(){
        $showAdapter = new ShowAdapter();
        $shows = $showAdapter->query($this->validQuery)->search()->shows();
        $this->assertTrue($shows->isNotEmpty());
        $this->assertEquals($shows->count(), 10);
        $this->assertEquals($shows->first()->name, 'Superman');
    }

    public function testSearch(){
        $showAdapter = new ShowAdapter();
        $shows = $showAdapter->search()->shows();
        $this->assertTrue($shows->isEmpty());
    }

    public function testShow(){
        $showAdapter = new ShowAdapter();
        $shows = $showAdapter->shows();
        $this->assertTrue($shows->isEmpty());
    }

}
