<?php

namespace App\Nova;

use App\Nova\Customer;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Lenses\StatusCountLens;
use Laravel\Nova\Fields\BelongsToMany;
use App\Nova\Relationships\OrderFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Query\Search\SearchableText;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';


    public static $with = [
        'brand', 'category'
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

            Image::make('Image')
            ->path('products')
            ->rules('nullable', 'image', 'mimes:png,jpg,jpeg,gif')
            ->help('Only png, jpg, and jpeg image extensions are accepted'),

            Text::make('Title')
                ->sortable()
                // ->showOnIndex( function (NovaRequest $request, $resource) {
                //     return $this-> title === 'Five, who had not.';
                // })
                ->rules('required', 'string')
                ->creationRules('unique:products,title')
                ->updateRules('unique:products,title,{{resourceId}}'),

            BelongsTo::make('Category')
                ->searchable()
                ->sortable()
                ->showCreateRelationButton()
                ->modalSize('3xl')
                ->rules('required', 'integer', 'exists:categories,id'),

            BelongsTo::make('Brand')
                ->searchable()
                ->sortable()
                ->showCreateRelationButton()
                ->modalSize('3xl')
                ->rules('required', 'integer', 'exists:brands,id'),

            Trix::make('Description')
                ->hideFromIndex()
                ->rules('required', 'string'),

            Boolean::make('Stock', 'inStock')
                ->filterable()
                ->hideFromIndex()
                ->rules('required', 'boolean')
                ->help('Whether the product has available stock'),

            Boolean::make('Published')
                ->filterable()
                ->hideFromIndex()
                ->rules('required', 'boolean')
                ->help('Whether this product should be published'),

            Number::make('Quantity')
                ->filterable()
                ->rules('required', 'integer', 'min:1'),

            Number::make('Price')
                ->step(0.01)
                ->filterable()
                ->rules('required', 'decimal:1,2', 'min:0.1'),

            URL::make('Url')
                ->displayUsing(fn ($value) => $value ? parse_url($value, PHP_URL_HOST): null)
                ->hideFromIndex()
                ->rules('nullable', 'url'),

            BelongsToMany::make('Product Customers', resource: Customer::class)
                ->fields(new OrderFields()),
        ];
    }

    public function subtitle()
    {
        return Str($this->description)->limit(100);
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
        return [
            new StatusCountLens(),
        ];
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
