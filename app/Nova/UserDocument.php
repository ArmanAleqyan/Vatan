<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserDocument extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\UserDocument::class;

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('status','Ожидает Проверки');
    }
    public function authorizedToDelete(Request $request)
    {
        return false;
    }


    public function authorizedToReplicate(Request $request)
    {
        return false;
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'document_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'user_id','document_name', 'document_id'
    ];

    public static function label()
    {

        $getDoc = \App\Models\UserDocument::where('status','Ожидает Проверки')->count();

        if($getDoc > 0){
            $getsDoc = $getDoc;
        }else{
            $getsDoc = '';
        }

        return 'Непроверенные Документы'.' '. ' '.$getsDoc;
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
//            ID::make()->sortable(),
            BelongsTo::make('Пользватель','UserDoc', 'App\Nova\User')->searchable(),
            BelongsTo::make('Тип Документа','user_documents', 'App\Nova\VatanServiceDocumentList'),

            Image::make('photo')->disk('public'),
//            Select::make('photo')->disk('public'),
            Select::make('Статус Проверки','status')->options([
                'Ожидает Проверки' => 'Ожидает Проверки',
                'Проверенно' => 'Проверенно',
                'Отказанно' => "Отказанно",
            ])->HideFromIndex(),
            Textarea::make('Примичение если есть','description'),
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
