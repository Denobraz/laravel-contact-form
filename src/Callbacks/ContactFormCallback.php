<?php

namespace Denobraz\LaravelContactForm\Callbacks;

use Denobraz\LaravelContactForm\Models\ContactForm;
use Illuminate\Foundation\Bus\Dispatchable;

abstract class ContactFormCallback
{
    use Dispatchable;

    public function __construct(protected ContactForm $contactForm)
    {
    }

    public abstract function handle(): void;
}
