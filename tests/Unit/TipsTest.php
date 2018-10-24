<?php

namespace Tests\Unit;

//error_reporting(err);

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class TipsTest extends TestCase
{

    /* Function to test tip insertion */
    public function testTipCreation()
    {
        $data = [
            'guid' => '336',
            'title' => 'New tip',
            'description' => 'description',
        ];
        $this->json('POST', '/api/tips', $data)
            ->assertStatus(200)
            ->assertSuccessful();
    }

    /* Test Function to get tip lists */
    public function testGetTipsList()
    {
        $response = $this->json('GET', '/api/tips');
        $response->assertStatus(200);
        $response->assertSuccessful();
    }

}

