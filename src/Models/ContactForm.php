<?php

namespace Denobraz\LaravelContactForm\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $type
 * @property array $data
 * @property array $cookies
 * @property array $meta
 */
class ContactForm extends Model
{
    protected $table = 'contact_forms';

    protected $fillable = [
        'type',
        'data',
        'cookies',
        'meta',
    ];

    protected $casts = [
        'data' => 'array',
        'cookies' => 'array',
        'meta' => 'array',
    ];

    public function data(string $key, mixed $default): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function cookie(string $key, mixed $default): mixed
    {
        return $this->cookies[$key] ?? $default;
    }

    public function meta(string $key, mixed $default): mixed
    {
        return $this->meta[$key] ?? $default;
    }
}
