<?php

namespace Tests\Unit;

use App\Exceptions\Handler;
use App\User;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HandlerTest extends TestCase
{
    private $handler;

    public function __construct()
    {
        parent::__construct();

        $this->handler = new Handler($this->createMock(Container::class));
        $this->request = $this->createMock(Request::class);
    }

    public function testRender()
    {
        $response = $this->handler->render(new Request(), new ModelNotFoundException());
        $this->assertEquals($response, response()->json([
            'errors' => [
                'code' => 404,
                'title' => 'Resource not found',
            ],
        ], 404));

        $response = $this->handler->render(new Request(), new NotFoundHttpException());
        $this->assertEquals($response, response()->json([
            'errors' => [
                'code' => 404,
                'title' => 'Page not found',
            ],
        ], 404));

        $response = $this->handler->render(new Request(), new MethodNotAllowedHttpException(['get']));
        $this->assertEquals($response, response()->json([
            'errors' => [
                'code' => 403,
                'title' => 'Method not allowed',
            ],
        ], 403));

        $response = $this->handler->render(new Request(), new PostTooLargeException());
        $this->assertEquals($response, response()->json([
            'errors' => [
                'code' => 400,
                'title' => 'Files size is too large',
            ],
        ], 400));

        $exception = new \Exception();
        $response = $this->handler->render(new Request(), $exception);
        $this->assertEquals($response, response()->json([
            'errors' => [
                'code' => $exception->getCode(),
                'title' => $exception->getMessage(),
            ],
        ], 401));

        auth()->login(factory(User::class)->create());
        $response = $this->handler->render(new Request(), $exception);
        $this->assertEquals($response, response()->json([
            'errors' => [
                'code' => $exception->getCode(),
                'title' => $exception->getMessage(),
            ],
        ], 400));
    }
}
