<?php

namespace Pinerp\Notes;

use Illuminate\Support\ServiceProvider;
use Pincommon\Layout\Migrator\MigratableTrait;
use Illuminate\Console\Scheduling\Schedule;

class PinerpNotesServiceProvider extends ServiceProvider
{
    use MigratableTrait;
    
    public static $pathToMigrations = '/vendor/pinerp/notes/migrations';
    
    public function boot()
    {
        // notify command add in cron
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('notes:notify')->everyMinute();
        });

        // Loading the routes file
        require __DIR__ . '/routes.php';

        $this->loadViewsFrom(realpath(__DIR__ . '/../resources/views'), 'notes');

        // load transition files
        $this->loadTranslationsFrom(realpath(__DIR__ . '/../resources/lang'), 'notes');

        $this->publishes(
            [
                realpath(__DIR__ . '/../public') => public_path('notes'),
            ], 'public'
        );

        viewper_push('left_menu', 'notes::left_menu', [], 101, '');

        ioc_lang_merge('perm_names', 'notes::permissions.perms');
        $this->app['perm_groups']->push(['name' => trans('notes::permissions.name'), 'prefix' => 'notes.']);
    }

    public function register()
    {
        $this->mergeConfigFrom( realpath( __DIR__.'/../config/permissions.php'), 'permissions' );
    }
}