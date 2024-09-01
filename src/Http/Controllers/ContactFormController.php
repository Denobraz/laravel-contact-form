<?php

namespace Denobraz\LaravelContactForm\Http\Controllers;

use App\Http\Controllers\Controller;
use Denobraz\LaravelContactForm\ContactFormService;
use Denobraz\LaravelContactForm\Http\Requests\ContactFormRequest;
use Illuminate\Http\JsonResponse;

class ContactFormController extends Controller
{
    public function __invoke(
        ContactFormRequest $request,
        ContactFormService $service
    ): JsonResponse
    {
        $service->handle($request->toData());
        return response()->json(['success' => true], 201);
    }
}
