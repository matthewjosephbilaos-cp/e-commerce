<?php

namespace App\Providers;

use App\Nova\User;
use App\Nova\Brand;
use App\Nova\Order;
use App\Nova\Product;
use App\Nova\Category;
use App\Nova\Customer;
use Laravel\Nova\Nova;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use App\Nova\Lenses\StatusCountLens;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::withBreadcrumbs();

        Nova::initialPath('/resources/customers');

        Nova::mainMenu(fn ($request) => [

            MenuSection::make('Customers', [
                MenuItem::resource(Customer::class)
            ])->icon('user-group')->collapsable(),

            MenuSection::make('Main', [
                MenuSection::make('Product', [
                    MenuItem::resource(Product::class),
                    MenuItem::lens(Product::class, StatusCountLens::class),
                ])->collapsable(),

                MenuItem::resource(Brand::class),
                MenuItem::resource(Category::class),
                MenuItem::resource(Order::class)
            ])->icon('briefcase')->collapsable(),

            MenuSection::make('Support', [
                MenuItem::resource(User::class)
            ])->icon('cog')->collapsable(),
        ]);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
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
