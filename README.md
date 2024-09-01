This small laravel package helps you quickly connect the contact form api for your site by simply defining the types and fields in the configuration file.

To install the package, run the command:

``composer require denobraz/laravel-contact-form``

After installation, you need to publish the configuration file:

``php artisan vendor:publish --provider="Denobraz\LaravelContactForm\ContactFormServiceProvider" --tag="config"``

After that, you can configure the contact form in the file `config/contact_form.php`.

To publish the migration file, run the command:

``php artisan vendor:publish --provider="Denobraz\LaravelContactForm\ContactFormServiceProvider" --tag="migrations"``

After that, you can run the migration:

``php artisan migrate``

To use contact form add the following code to your api routes:

```php

Route::post('/contact-form', Denobraz\LaravelContactForm\Http\Controllers\ContactFormController::class);

```

Default configuration file include `default` contact form type with `name`, `email`, `phone`, `message` fields.

```php

'types' => [
        // `default` is the name of the contact form type
        'default' => [
            'data' => [
                // Here is rules for validation
                'name' => 'string|required',
                'email' => 'string|required|email',
                'phone' => 'string|nullable',
                'message' => 'string|nullable',
            ],
            'messages' => [
                // If you want to override the default message for some field
                'name.required' => 'Name is required',
            ],
            'attributes' => [
                // If you want to override the default attribute name for some field
                'name' => 'Name',
            ],
            'callbacks' => [
                // Here is the list of callbacks that will be called after the form is validated
                Denobraz\LaravelContactForm\Callbacks\DummyContactFormCallback::class,
            ]
        ]
    ]
```

You can attach callbacks to any type of contact form (notification to the administrator, response to the client, sending an application to the CRM, etc...).

Any callback is Job-like class that extends `Denobraz\LaravelContactForm\Callbacks\ContactFormCallback`.

If you want create queueable callback, you can extends `Denobraz\LaravelContactForm\Callbacks\QueueableContactFormCallback` class.

Here is example of callback that sends email to the administrator:

```php

namespace App\ContactForm\Callbacks;

use App\Notifications\ManagerContactFormNotification;
use Denobraz\LaravelContactForm\Callbacks\ContactFormCallback;
use Illuminate\Support\Facades\Notification;

class SendManagerEmail extends ContactFormCallback
{
    public function handle(): void
    {
        $notification = new ManagerContactFormNotification($this->contactForm);
        Notification::route('mail', 'admin@test.com')->notify($notification);
    }
}

```

The configuration also allows you to save forms in the database, manage the storage of cookies, ip, user-agent, if necessary. (Don't forget to notify the users about this)
