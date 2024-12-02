<?php

namespace App\Nova;

use App\Nova\User;
use App\Nova\Customer;
use App\Models\User as UserModel;
use App\Models\Customer as CustomerModel;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Address extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Address>
     */
    public static $model = \App\Models\Address::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'street';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'street', 'barangay', 'city', 'country', 'postal_code',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            MorphTo::make('Addressable')
                ->types([
                    Customer::class,
                    User::class
                ])->searchable(),

            Text::make('Street')
                ->sortable()
                ->rules('nullable', 'string', 'max:255'),

            Text::make('Barangay')
                ->sortable()
                ->rules('required', 'string', 'max:255'),

            Text::make('City')
                ->sortable()
                ->rules('required', 'string', 'max:255'),

            Text::make('Country')
                ->sortable()
                ->rules('required', 'string', 'max:255'),

            Text::make('Postal Code')
                ->sortable()
                ->rules('required', 'string', 'max:255'),
        ];
    }

    public function subtitle() {
        return match ($this->addressable::class) {
            CustomerModel::class => 'Customer: ' . $this->addressable->name,
            UserModel::class => 'User: ' . $this->addressable->name,
            default => null,
        };
    }
    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
