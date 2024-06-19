<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Unit\Infrastructure\QueryServices;

use App\Infrastructure\QueryServices\CurrentUserQueryService;
use App\Models\UserDetailEloquent;
use App\Models\UserEloquent;
use App\Models\UserHashedPasswordEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrentUserQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_存在するユーザーの情報を取得できること(): void
    {
        /** @var UserEloquent $user */
        $user = UserEloquent::factory()
            ->has(UserDetailEloquent::factory())
            ->create();

        $current_user_dto = CurrentUserQueryService::getCurrentUserById($user->id);

        $this->assertSame($user->id, $current_user_dto->id);
        $this->assertSame($user->userDetailEloquent->display_name, $current_user_dto->display_name);
        $this->assertSame($user->userDetailEloquent->icon_path, $current_user_dto->icon_path);
        $this->assertObjectNotHasProperty('password', $current_user_dto);
    }

    public function test_存在しないユーザーの情報を取得できないこと(): void
    {
        $not_exist_user_id = 'not_exist_user_id';

        $current_user_dto = CurrentUserQueryService::getCurrentUserById($not_exist_user_id);

        $this->assertNull($current_user_dto);
    }
}
