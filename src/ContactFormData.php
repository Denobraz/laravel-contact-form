<?php

namespace Denobraz\LaravelContactForm;

class ContactFormData
{
    public function __construct(
        private readonly string $type,
        private readonly array  $data,
        private readonly array  $cookies,
        private readonly array  $meta,
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }
}
