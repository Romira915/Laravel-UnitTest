<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\PostArticleEditRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PostArticleEditRequestTest extends TestCase
{
    #[DataProvider('provideTestData')]
    public function test_バリデーションが正常に動作すること(array $input, bool $expect)
    {
        $request = new PostArticleEditRequest();
        $validator = Validator::make($input, $request->rules());
        $this->assertSame($expect, $validator->passes());
    }

    public static function provideTestData(): array
    {
        return [
            '正常' => [
                [
                    'title' => 'Test title',
                    'body' => 'Test body',
                ],
                true
            ],
            'タイトルが空' => [
                [
                    'title' => '',
                    'body' => 'Test body',
                ],
                false
            ],
            '本文が空' => [
                [
                    'title' => 'Test title',
                    'body' => '',
                ],
                false
            ],
            'タイトルが101文字' => [
                [
                    'title' => str_repeat('a', 101),
                    'body' => 'Test body',
                ],
                false
            ],
            '本文が8001文字' => [
                [
                    'title' => 'Test title',
                    'body' => str_repeat('a', 8001),
                ],
                false
            ],
        ];
    }
}
