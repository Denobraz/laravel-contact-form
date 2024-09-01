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
        $meta = $data->getMeta();

        if (!config('contact_form.save_ip', false) && isset($meta['ip'])) {
            unset($meta['ip']);
        }

        if (!config('contact_form.save_user_agent', false) && isset($meta['user_agent'])) {
            unset($meta['user_agent']);
        }

        if (!config('contact_form.save_referer', false) && isset($meta['referer'])) {
            unset($meta['referer']);
        }

        if (!config('contact_form.save_user_id', false) && isset($meta['user_id'])) {
            unset($meta['user_id']);
        }

        $contactForm->meta = $meta;

        if (config('contact_form.save_cookies', false)) {
            $contactForm->cookies = $data->getCookies();
        }

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
