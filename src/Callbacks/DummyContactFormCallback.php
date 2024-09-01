<?php

namespace Denobraz\LaravelContactForm\Callbacks;

class DummyContactFormCallback extends ContactFormCallback
{
    public function handle(): void
    {
    //    $email = $this->contactForm->data['email'];
    //    Mail::to($email)->send(new ContactFormMail($this->contactForm));
    }
}