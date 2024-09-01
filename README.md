This small laravel package helps you quickly connect the contact form api for your site by simply defining the types and fields in the configuration file.

## Installation

To install the package, run the command:

```bash
composer require denobraz/laravel-contact-form
```

After installation, you need to publish the configuration file:

```bash
php artisan vendor:publish --provider="Denobraz\LaravelContactForm\ContactFormServiceProvider" --tag="config"
```

After that, you can configure the contact form in the file `config/contact_form.php`.

To publish the migration file, run the command:

```bash
php artisan vendor:publish --provider="Denobraz\LaravelContactForm\ContactFormServiceProvider" --tag="migrations"
```

After that, you can run the migration:

```bash
php artisan migrate
```

## Usage

### Registering the routes

To use contact form add the following code to your api routes:

```php

Route::post('/contact-form', Denobraz\LaravelContactForm\Http\Controllers\ContactFormController::class);

```

### Define contact form types

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
                // You can left this array empty
                'name.required' => 'Name is required',
            ],
            'attributes' => [
                // If you want to override the default attribute name for some field
                // You can left this array empty
                'name' => 'Name',
            ],
            'callbacks' => [
                // Here is the list of callbacks that will be called after the form is validated
                // You can left this array empty (maybe just for record form data in the database)
                Denobraz\LaravelContactForm\Callbacks\DummyContactFormCallback::class,
            ]
        ],
        // `newsletter` is the name of the contact form type
        'newsletter' => [
            'data' => [
                'email' => 'string|required|email',
            ],
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
        // You can access the contact form data, cookies, meta, etc. using the following methods:
        $email = $this->contactForm->data('email');

        // To use the cookies, and meta-data, you need allow storing them in the config file.
        $fbpCookie = $this->contactForm->cookie('fbp');
        $ip = $this->contactForm->ip();
        $userAgent = $this->contactForm->userAgent();
        $referer = $this->contactForm->referer();
        $userId = $this->contactForm->userId();
        $someOtherMeta = $this->contactForm->meta('some_other_meta');
    
        // In the notification class we pass the contact form model with data
        $notification = new ManagerContactFormNotification($this->contactForm);
        Notification::route('mail', 'admin@test.com')->notify($notification);
    }
}

```

Also configuration allows you: (Don't forget to notify the users about sensitive data processing)
- `save_contact_forms` - if you want to store the form data in the database
- `save_cookies` - if you want to store the user's cookies
- `save_ip` - if you want to store the user's ip
- `save_user_agent` - if you want to store the user's user-agent
- `save_referrer` - if you want to store the user's referrer
- `save_user_id` - if you want to store the user's id

## Examples

Request:

```json
{
  "type": "default",
  "data": {
    "name": "John Doe",
    "email": "example@test.com",
    "phone": "+1234567890",
    "message": "Hello, world!"
  }
}
```

Error response:

```json
{
    "message": "Name is required (and 1 more error)",
    "errors": {
        "data.name": [
            "Name is required"
        ],
        "data.email": [
            "The Email field is required."
        ]
    }
}
```

Success response:

```json
{
    "success": true
}
```
You can see frontend code example in the `demo` directory.
