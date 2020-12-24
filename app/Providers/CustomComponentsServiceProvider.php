<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Collective\Html\FormFacade;

class CustomComponentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        FormFacade::component('bsText', 'components.form.text', ['name', 'value', 'attributes']);
        FormFacade::component('bsTextarea', 'components.form.textarea', ['name', 'value', 'attributes']);
        FormFacade::component('bsBtnSubmit', 'components.form.btn', ['value', 'attributes' => []]);
        FormFacade::component('bsSelect', 'components.form.select', ['name', 'value', 'attributes', 'labelValue', 'selected' => null]);
    }
}
