<?php

namespace Kreatorij\NovaFilemanager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Kreatorij\NovaFilemanager\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->config();

		$this->app->booted(function () {
			$this->routes();
		});

		Nova::serving(function (ServingNova $event) {
			Nova::script('filemanager-field', __DIR__ . '/../dist/js/field.js');
			// Nova::style('filemanager-field', __DIR__.'/../dist/css/field.css');
		});
	}

	/**
	 * Register the tool's routes.
	 *
	 * @return void
	 */
	protected function routes()
	{
		if ($this->app->routesAreCached()) {
			return;
		}

		Nova::router(['nova', Authorize::class], config('nova-filemanager.path', 'filemanager'))
			->group(__DIR__ . '/../routes/inertia.php');

		Route::middleware(['nova', Authorize::class])
			->namespace('Kreatorij\NovaFilemanager\Http\Controllers')
			->prefix('nova-vendor/kreatorij/nova-filemanager')
			->group(__DIR__ . '/../routes/api.php');
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

	private function config()
	{
		if ($this->app->runningInConsole()) {
			// Publish config
			$this->publishes([
				__DIR__ . '/../config/' => config_path(),
			], 'nova-filemanager-config');
		}

		$this->mergeConfigFrom(
			__DIR__ . '/../config/nova-filemanager.php',
			'nova-filemanager'
		);
	}
}
