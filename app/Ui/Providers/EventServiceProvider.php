<?php
namespace App\Ui\Providers;

use App\Ui\Providers\EventServiceProvider;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider{

    protected $listen = [
            // 'user.admin.update-password' => [
            //    'Webkul\Admin\Listeners\PasswordChange@sendUpdatePasswordMail'
            // ],
        ];
}