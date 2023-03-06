<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Http\Requests\NovaRequest;

class Holiday extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Holiday::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title','country', 'day', 'month', 'description',
    ];


    public static function label()
    {
        return 'Праздники';
    }
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Заголовок','title')->rules('required', 'max:255')->required(),
            Date::make('Дата','dateTime')->rules('required', 'max:255')->required()->hideFromIndex(),
            Select::make('Страна','country')->sortable()->options([
                'Таджикстан' => 'Таджикстан',
                'Узбекистан' => 'Узбекистан',
                'Кыргызстан' => 'Кыргызстан',
                'Россия' => 'Россия',
            ])->sortable()->required() ->rules('required', 'max:255'),
//            Select::make('День','day')->options([
//                '01' => '1',
//                '02' => '2',
//                '3' => '3',
//                '4' => '4',
//                '5' => '5',
//                '6' => '6',
//                '7' => '7',
//                '8' => '8',
//                '9' => '9',
//                '10' => '10',
//                '11' => '11',
//                '12' => '12',
//                '13' => '13',
//                '14' => '14',
//                '15' => '15',
//                '16' => '16',
//                '17' => '17',
//                '18' => '18',
//                '19' => '19',
//                '20' => '20',
//                '21' => '21',
//                '22' => '22',
//                '23' => '23',
//                '24' => '24',
//                '25' => '25',
//                '26' => '26',
//                '27' => '27',
//                '28' => '28',
//                '29' => '29',
//                '30' => '30',
//                '31' => '31',
//            ])->required() ->rules('required', 'max:255')->sortable(),
//            Select::make('Месяц','month')->options([
//                '1' => '1',
//                '2' => '2',
//                '3' => '3',
//                '4' => '4',
//                '5' => '5',
//                '6' => '6',
//                '7' => '7',
//                '8' => '8',
//                '9' => '9',
//                '10' => '10',
//                '11' => '11',
//                '12' => '12',
//            ])->required() ->rules('required', 'max:255')->sortable(),
            Textarea::make('Описание','description')->required() ->rules('required'),
            Image::make('Фотография','photo')->required()->disk('public')
        ];
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
