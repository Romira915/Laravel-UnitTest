<?php /** @noinspection NonAsciiCharacters */

declare(strict_types=1);

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\Auth\PostAuthRegisterRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostAuthRegisterRequestTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[DataProvider('provideTestData')]
    public function test_バリデーションが正常に動作すること(array $input, bool $expect)
    {
        $request = new PostAuthRegisterRequest();
        $validator = Validator::make($input, $request->rules());
        $this->assertSame($expect, $validator->passes());
    }

    public static function provideTestData(): array
    {
        $user_icon = UploadedFile::fake()->image('user_icon.jpg');

        return [
            '正常' => [
                [
                    'display_name' => 'userName',
                    'password' => 'NPB5ymg9ufy*gvp5ynh',
                    'password_confirmation' => 'NPB5ymg9ufy*gvp5ynh',
                    'user_icon' => $user_icon,
                ],
                true
            ],
            '表示名が既に存在' => [
                [
                    'display_name' => 'test',
                    'password' => 'NPB5ymg9UFY*GVP5YNH',
                    'password_confirmation' => 'NPB5ymg9UFY*GVP5YNH',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            '表示名に使えない文字が含まれる' => [
                [
                    'display_name' => '日本語',
                    'password' => 'NPB5ymg9ufy*gvp5ynh',
                    'password_confirmation' => 'NPB5ymg9ufy*gvp5ynh',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            '表示名が101文字' => [
                [
                    'display_name' => str_repeat('a', 101),
                    'password' => 'NPB5ymg9ufy*gvp5ynh',
                    'password_confirmation' => 'NPB5ymg9ufy*gvp5ynh',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            '表示名が空' => [
                [
                    'display_name' => '',
                    'password' => 'NPB5ymg9ufy*gvp5ynh',
                    'password_confirmation' => 'NPB5ymg9ufy*gvp5ynh',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'パスワードが空' => [
                [
                    'display_name' => 'userName',
                    'password' => '',
                    'password_confirmation' => 'NPB5ymg9ufy*gvp5ynh',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'パスワードが7文字' => [
                [
                    'display_name' => 'userName',
                    'password' => 'NPB5ymg',
                    'password_confirmation' => 'NPB5ymg',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'パスワードが31文字' => [
                [
                    'display_name' => 'userName',
                    'password' => 'NPB5ymg9ufy*gvp5ynhNPB5ymg9ufy*gvp5ynh',
                    'password_confirmation' => 'NPB5ymg9ufy*gvp5ynhNPB5ymg9ufy*gvp5ynh',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'パスワードが英字を含まない' => [
                [
                    'display_name' => 'userName',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'パスワードが大文字を含まない' => [
                [
                    'display_name' => 'userName',
                    'password' => 'npb5ymg9ufy*gvp5ynh',
                    'password_confirmation' => 'npb5ymg9ufy*gvp5ynh',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'パスワードが小文字を含まない' => [
                [
                    'display_name' => 'userName',
                    'password' => 'NPB5
                    ymg9UFY*GVP5YNH',
                    'password_confirmation' => 'NPB5ymg9ufy*gvp5ynh',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'パスワードが数字を含まない' => [
                [
                    'display_name' => 'userName',
                    'password' => 'NPBymgufy*gvpynh',
                    'password_confirmation' => 'NPBymgufy*gvpynh',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'パスワードが記号を含まない' => [
                [
                    'display_name' => 'userName',
                    'password' => 'NPB5ymg9ufyGVP5YNH',
                    'password_confirmation' => 'NPB5ymg9ufyGVP5YNH',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'パスワードが簡単すぎる' => [
                [
                    'display_name' => 'userName',
                    'password' => 'password',
                    'password_confirmation' => 'password',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'パスワードが一致しない' => [
                [
                    'display_name' => 'userName',
                    'password' => 'NPB5ymg9ufy*gvp5ynh',
                    'password_confirmation' => 'NPB5ymg9ufy*gvp5yn',
                    'user_icon' => $user_icon,
                ],
                false
            ],
            'アイコンが空' => [
                [
                    'display_name' => 'userName',
                    'password' => 'NPB5ymg9ufy*gvp5ynh',
                    'password_confirmation' => 'NPB5ymg9ufy*gvp5ynh',
                    'user_icon' => null,
                ],
                false
            ],
        ];
    }
}
