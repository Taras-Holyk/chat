<?php

namespace Tests\Unit;

use App\Http\Requests\FormRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormRequestTest extends TestCase
{
    public function testFailedValidation()
    {
        $mock = $this->getMockBuilder(FormRequest::class)
            ->getMockForAbstractClass();
        $this->expectException(HttpResponseException::class);

        $mock->failedValidation(app(RegisterRequest::class));
    }
}
