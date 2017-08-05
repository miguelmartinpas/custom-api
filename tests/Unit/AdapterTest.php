<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use CustomApi\Services\Adapter;

class AdapterTest extends TestCase {

    protected $validQuery = "Superman";
    protected $invalidQuery = "qwertyqwerty";

    public function testSearchValuesWithNullParameter(){
        $adapter = new Adapter();
        $values = $adapter->searchValues(null);
        $this->assertEquals($values, null);
    }

    public function testSearchValuesWithInvalidParameter(){
        $adapter = new Adapter();
        $values = $adapter->searchValues($this->invalidQuery);
        $this->assertEquals($values, []);
        return $values;
    }

    public function testSearchValuesWithValidParameter(){
        $adapter = new Adapter();
        $adapter->forceClearCache();
        $values = $adapter->searchValues($this->validQuery);
        $this->assertEquals(count($values), 10);
        return $values;
    }

    /**
     * @depends testSearchValuesWithValidParameter
     */
    public function testParseResponseWithValidParameter(){
        $adapter = new Adapter();
        $groupOfValues = func_get_args();
        $parsedValues = $adapter->parseResponse($groupOfValues[0], $this->validQuery);
        $this->assertEquals(count($parsedValues), 1);
        return $parsedValues;
    }

    /**
     * @depends testSearchValuesWithValidParameter
     */
    public function testParseResponseWithInValidParameter(){
        $adapter = new Adapter();
        $groupOfValues = func_get_args();
        $parsedValues = $adapter->parseResponse($groupOfValues[0], $this->invalidQuery);
        $this->assertEquals(count($parsedValues), 0);
        return $parsedValues;
    }

    public function testParseResponseWithInValidParameterEmptyArray(){
        $adapter = new Adapter();
        $parsedValues = $adapter->parseResponse([], $this->invalidQuery);
        $this->assertEquals(count($parsedValues), 0);
        return $parsedValues;
    }
}
