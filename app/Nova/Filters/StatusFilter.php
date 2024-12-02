<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class StatusFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    public $name = 'Product Status';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->whereHas('productsOrdered', fn ($query) => $query->where('status', $value));
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
            'Pending' => 'Pending',
            'Processing' => 'Processing',
            'Out For Delivery' => 'Out For Delivery',
            'Delivered' => 'Delivered',
            'Failed Delivery' => 'Failed Delivery',
            'Cancelled' => 'Cancelled'
        ];
    }
}
