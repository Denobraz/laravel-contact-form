<?php

namespace Denobraz\LaravelContactForm\Http\Requests;

use Denobraz\LaravelContactForm\ContactFormData;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function rules(): array
    {
        $types = array_keys(config('contact_form.types', []));
        $rules = Arr::prependKeysWith(config("contact_form.types.{$this->input('type')}.data", []), 'data.');
        $rules['type'] = ['required', Rule::in($types)];
        return $rules;
    }

    public function attributes(): array
    {
        return  Arr::prependKeysWith(config("contact_form.types.{$this->input('type')}.attributes", []), 'data.');
    }

    public function messages(): array
    {
        return  Arr::prependKeysWith(config("contact_form.types.{$this->input('type')}.messages", []), 'data.');
    }

    public function toData(): ContactFormData
    {
        $type = $this->input('type');
        $data = $this->validated();
        $meta = [
            'ip' => config('contact_form.save_ip') ? $this->ip() : null,
            'user_agent' => config('contact_form.save_user_agent') ? $this->userAgent() : null,
            'referer' => config('contact_form.save_referer') ? $this->headers->get('referer') : null,
        ];
        $meta = array_filter($meta);
        $cookies = config('contact_form.save_cookies') ? $this->cookies->all() : [];

        return new ContactFormData($type, $data, $cookies, $meta);
    }
}
