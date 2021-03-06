<?php

namespace Tests;

use App\Http\Controllers\TurbineController;
use TestCase;

class DataTest extends TestCase
{
    /**
     * The initial GET request
     */
    public $request;

    /**
     * The API data
     */
    public $turbineData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = $this->get('/turbine-data');
        $this->turbineData = json_decode($this->request->response->getContent());
    }

    /** @test */
    public function the_data_endpoint_returns_a_200_response()
    {
        $this->request->assertResponseStatus(200);
    }

    /** @test */
    public function the_returned_data_has_the_correct_response_for_the_third_turbine()
    {
        $this->assertEquals(TurbineController::STATUS_CODES[3] , $this->turbineData[2]->status);
    }

    /** @test */
    public function the_returned_data_has_the_correct_response_for_the_fifth_turbine()
    {
        $this->assertEquals(TurbineController::STATUS_CODES[5], $this->turbineData[4]->status);
    }

    /** @test */
    public function the_returned_data_has_the_correct_response_for_the_fifteenth_turbine()
    {
        $expected = TurbineController::STATUS_CODES[3] . ' and ' . TurbineController::STATUS_CODES[5];

        $this->assertEquals($expected, $this->turbineData[14]->status);
    }

    /** @test */
    public function it_returns_the_turbine_codes() {
        $response = $this->get('/turbine-codes');
        $codes = json_decode($response->response->getContent(), true);

        $this->assertEquals(TurbineController::STATUS_CODES, $codes);
    }

    /** @test */
    public function it_returns_the_correct_status_code_when_inspecting_a_single_turbine()
    {
        $status = json_decode($this->get('/turbine-data/' . '3')->response->getContent());
        $this->assertEquals(TurbineController::STATUS_CODES[3], $status->status);
    }

    /** @test */
    public function it_returns_an_empty_status_when_the_turbine_is_healthy()
    {
        $data = json_decode($this->get('/turbine-data/' . '1')->response->getContent());
        $this->assertEquals('', $data->status);
    }
}