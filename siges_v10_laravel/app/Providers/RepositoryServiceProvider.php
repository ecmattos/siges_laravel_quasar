<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\PlanTypeRepository::class, \App\Repositories\PlanTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PlanSubTypeRepository::class, \App\Repositories\PlanSubTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PlanRepository::class, \App\Repositories\PlanRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PlanStatusRepository::class, \App\Repositories\PlanStatusRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TrashRepository::class, \App\Repositories\TrashRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ClientRepository::class, \App\Repositories\ClientRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MaterialUnitRepository::class, \App\Repositories\MaterialUnitRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MaterialRepository::class, \App\Repositories\MaterialRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CompanyPositionRepository::class, \App\Repositories\CompanyPositionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CustomerRepository::class, \App\Repositories\CustomerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EmployeeRepository::class, \App\Repositories\EmployeeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProviderRepository::class, \App\Repositories\ProviderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderRepository::class, \App\Repositories\OrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\WarehouseRepository::class, \App\Repositories\WarehouseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MeetingTypeRepository::class, \App\Repositories\MeetingTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MeetingRepository::class, \App\Repositories\MeetingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CityRepository::class, \App\Repositories\CityRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StateRepository::class, \App\Repositories\StateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RegionRepository::class, \App\Repositories\RegionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderStatusRepository::class, \App\Repositories\OrderStatusRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CompanySectorRepository::class, \App\Repositories\CompanySectorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);     
        //:end-bindings:
    }
}
