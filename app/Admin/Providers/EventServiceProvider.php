<?php
namespace App\Admin\Providers;

use App\Admin\Providers\EventServiceProvider;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider{

    protected $listen = [
            // 'user.admin.update-password' => [
            //    'Webkul\Admin\Listeners\PasswordChange@sendUpdatePasswordMail'
            // ],
        ];
}