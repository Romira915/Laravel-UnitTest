<?php /** @noinspection NonAsciiCharacters */

namespace Feature;

use App\Models\UserDetailEloquent;
use App\Models\UserEloquent;
use App\Models\UserHashedPasswordEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostAuthLoginControllerTest extends TestCase
{
    use refreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_正しいnameとpasswordでログインに成功すること(): void
    {
        /** @var UserEloquent $user */
        $user = UserEloquent::factory()->has(UserDetailEloquent::factory()->state([
            'display_name' => Str::random(20),
        ]))->has(UserHashedPasswordEloquent::factory()->state([
            'hashed_password' => password_hash('password', PASSWORD_BCRYPT),
        ]))->create();

        $response = $this->post('/auth/login', [
            'display_name' => $user->userDetailEloquent->display_name,
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHasNoErrors();
    }

    public function test_存在しないnameでログインに失敗すること(): void
    {
        $response = $this->post('/auth/login', [
            'display_name' => 'not_exist_name',
            'password' => 'not_exist_password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('auth_login');
    }
}
