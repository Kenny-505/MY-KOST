<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ImageUploadService;
use App\Services\MidtransService;
use App\Services\BookingPaymentService;
use App\Services\PDFExportService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ImageUploadService::class, function ($app) {
            return new ImageUploadService();
        });

        $this->app->singleton(MidtransService::class, function ($app) {
            return new MidtransService();
        });

        $this->app->singleton(BookingPaymentService::class, function ($app) {
            return new BookingPaymentService($app->make(MidtransService::class));
        });

        $this->app->singleton(PDFExportService::class, function ($app) {
            return new PDFExportService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
