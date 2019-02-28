<?php

namespace App\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Entities\Client;

class ManagerTenant 
{
    public function setConnection(Client $client)
    {
        DB::purge('tenant');

        config()->set('database.connections.tenant.host', $client->hostname);
        config()->set('database.connections.tenant.database', $client->database);
        config()->set('database.connections.tenant.username', $client->username);
        config()->set('database.connections.tenant.password', $client->password);

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();

    }

    public function domainIsMain()
    {
        return request()->getHost() == config('tenant.domain_main');
    }
}