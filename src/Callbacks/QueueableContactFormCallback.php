<?php

namespace Denobraz\LaravelContactForm\Callbacks;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class QueueableContactFormCallback extends ContactFormCallback implements ShouldQueue
{
    use Queueable;
}