<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetIndexTest extends TestCase
{
    public function test_limitクエリなしでアクセスしたとき200が返ってくること(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_limitの値が正でアクセスしたとき200が返ってくること(): void
    {
        $response = $this->get('/?limit=1');

        $response->assertStatus(200);
    }

    public function test_limitの値が負でアクセスしたとき302が返ってくること(): void
    {
        $response = $this->get('/?limit=-1');

        $response->assertStatus(302);
    }

    public function test_limitの値が許可されていない値でアクセスしたとき302が返ってくること(): void
    {
        $response = $this->get('/?limit=abc');

        $response->assertStatus(302);
    }
}
