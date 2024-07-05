<?php

namespace App\Providers;

use App\Models\notifications;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {

            $notifications = notifications::
                // where('is_done',0)->
                orderBy('id', 'DESC')->get()->map(function ($row) {
                    $date = $row->created_at;
                    $now = now();

                    $monthdate = Carbon::parse($date);
                    $dateDiff = $monthdate->diffInMinutes(Carbon::now());

                    if ($dateDiff == 0) {
                        $row->date1 = 'Now';
                    }
                    if ($dateDiff < 60) {
                        if ($dateDiff == 1)
                            $row->date1 = $dateDiff . ' minute ago';
                        else
                            $row->date1 = $dateDiff . ' minutes ago';
                    } else {
                        $dateDiff = $monthdate->diffInHours(Carbon::now());
                        if ($dateDiff < 24) {
                            if ($dateDiff == 1)
                                $row->date1 = $dateDiff . ' hour ago';
                            else
                                $row->date1 = $dateDiff . ' hours ago';
                        } else {
                            $dateDiff = $monthdate->diffInDays(Carbon::now());
                            if ($dateDiff < 30) {
                                if ($dateDiff == 1)
                                    $row->date1 = $dateDiff . ' day ago';
                                else
                                    $row->date1 = $dateDiff . ' days ago';
                            } else {
                                $row->date1 = 'from ' . $monthdate->toDateString();
                            }
                        }
                    }
                    return $row;
                });


            $view->with(['notifications' => $notifications]);
        });
    }
}
