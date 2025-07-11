<?php

namespace App\Providers;

use App\Domain\Sale\Contracts\SaleComissionRepositoryInterface;
use App\Domain\Sale\Services\CalculateSaleCommissionService;
use App\Domain\Sale\Services\ProcessSaleComissionService;
use App\Infrastructure\Sale\Factorys\CommissionStrategyFactory;
use App\Infrastructure\Sale\Repositories\JsonSaleCommisionRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            SaleComissionRepositoryInterface::class,
            JsonSaleCommisionRepository::class
        );

        $this->app->singleton(CommissionStrategyFactory::class, function (Application $app) {
            return new CommissionStrategyFactory($app);
        });

        $this->app->singleton(CalculateSaleCommissionService::class, function (Application $app) {
            return new CalculateSaleCommissionService(
                $app->make(CommissionStrategyFactory::class)
            );
        });

        $this->app->singleton(ProcessSaleComissionService::class, function (Application $app) {
            return new ProcessSaleComissionService(
                $app->make(SaleComissionRepositoryInterface::class),
                $app->make(CalculateSaleCommissionService::class)
            );
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
