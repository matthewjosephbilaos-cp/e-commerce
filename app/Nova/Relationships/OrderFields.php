<?php

namespace App\Nova\Relationships;

use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class OrderFields
{

    public function __invoke(NovaRequest $request, $relatedModel)
    {

        return [
            Number::make('Quantity')
                ->filterable()
                ->rules('required', 'integer'),

            Badge::make('Status')
                ->filterable()
                ->map([
                    'Pending' => 'info',
                    'Processing' => 'info',
                    'Out For Delivery' => 'warning',
                    'Delivered' => 'success',
                    'Failed Delivery' => 'danger',
                    'Cancelled' => 'danger'
                ])

                ];
    }
}

