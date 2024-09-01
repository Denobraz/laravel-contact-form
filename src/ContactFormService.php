<?php

namespace Denobraz\LaravelContactForm;

use Denobraz\LaravelContactForm\Models\ContactForm;

class ContactFormService
{
    public function handle(ContactFormData $data): ContactForm
    {
        $contactForm = new ContactForm();
        $contactForm->type = $data->getType();
        $contactForm->data = $data->getData();
        $contactForm->meta = $data->getMeta();
        $contactForm->cookies = $data->getCookies();

        if (config('contact_form.save_contact_forms', false)) {
            $contactForm->save();
        }

        $callbacks = config('contact_form.types.' . $contactForm->type . '.callbacks', []);
        foreach ($callbacks as $callback) {
            if (is_string($callback)) {
                $callback = app($callback);
            }
            $callback::dispatch($contactForm);
        }

        return $contactForm;
    }
}