<?php

namespace App\Providers;

use http\Header;
use Illuminate\Support\Facades\Gate;
use App\Nova\License;
use App\Nova\Release;
use App\Nova\Series;
use Wdelfuego\Nova4\CustomizableFooter\Footer;
use App\Nova\User;
use App\Nova\UserDocument;
use App\Nova\Post;
use App\Nova\Comment;
use App\Nova\Comentreply;
use App\Nova\Group;
use App\Nova\VatanService;
use App\Nova\RegisterPrice;
use App\Nova\Holiday;
use App\Nova\VatanServiceDocumentList;
use Illuminate\Http\Request;
use Laravel\Nova\Nova\Dashboards\Main;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Fields\Text;
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
        Nova::withoutNotificationCenter();
        Nova::script('myScript', public_path('AdminScript.js'));



        Nova::style('asd', asset('NovaCss.css'));
        Footer::set('<p class="text-center">Vatan </p>');


        Nova::mainMenu(function (Request $request) {
            $get = \App\Models\Chat::where('receiver_id', 1)->sum('review');
            if($get > 0){
                $gets = $get;
            }else{
                $gets = '';
            }




            return [


                MenuSection::make('Пользватели', [
                    MenuItem::resource(User::class),
                    MenuItem::resource(UserDocument::class),
                ])->icon('user')->collapsable(),

                MenuSection::make('Посты', [
                    MenuItem::resource(Post::class),
                ])->icon('post')->collapsable(),

                MenuSection::make('Группы', [
                    MenuItem::resource(Group::class),
                ])->icon('post')->collapsable(),

                MenuSection::make('Услуги', [
                    MenuItem::resource(VatanService::class),
                    MenuItem::resource(RegisterPrice::class),
                    MenuItem::resource(VatanServiceDocumentList::class),
                ])->icon('post')->collapsable(),

                MenuSection::make('Праздники', [
                    MenuItem::resource(Holiday::class),

                ])->icon('post')->collapsable(),


                MenuItem::externalLink('Переписки'.' ' . ' '.$gets,  env('APP_URL').'/getAdminMessage'),



//

//                MenuSection::make('Комментарии', [
//                    MenuItem::resource(Comment::class),
//                ])->icon('comments')->collapsable(),
//
//                MenuSection::make('Oтвет комментрия', [
//                    MenuItem::resource(Comentreply::class),
//                ])->icon('comments')->collapsable(),
            ];
        });
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

    }
}
