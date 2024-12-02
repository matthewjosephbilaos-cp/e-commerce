<?php

namespace App\Nova\Lenses;

use Laravel\Nova\Nova;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;

class StatusCountLens extends Lens
{
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
    ];

    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->fromSub(fn ($query) => $query
                ->from('products')
                ->select('id', 'image', 'title')
                ->addSelect([
                    'cancelled_order' => fn ($query) => $query->selectRaw('count(id)')
                        ->from('customer_product')
                        ->whereColumn('customer_product.product_id', 'products.id')
                        ->where('status', 'Cancelled'),

                    'delivered_order' => fn ($query) => $query->selectRaw('count(id)')
                        ->from('customer_product')
                        ->whereColumn('customer_product.product_id', 'products.id')
                        ->where('status', 'Delivered')
                ]),
                'products'
            )
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(Nova::__('ID'), 'id')->sortable(),

            Image::make('image'),

            Text::make('title')->sortable(),

            Number::make('Cancelled Order')->sortable(),

            Number::make('Delivered Order')->sortable(),

        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'status-count-lens';
    }
}
