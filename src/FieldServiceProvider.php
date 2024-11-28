<?php

namespace Eom\NovaChecklistField;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Outl1ne\NovaTranslationsLoader\LoadsNovaTranslations;

class FieldServiceProvider extends ServiceProvider
{
    use LoadsNovaTranslations;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslations(__DIR__.'/../lang', 'nova_checklist_field', true);

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-checklist-field', __DIR__.'/../dist/js/field.js');
            Nova::style('nova-checklist-field', __DIR__.'/../dist/css/field.css');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
