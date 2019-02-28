<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOrdersTable.
 */
class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			
			$table->integer('customer_id')->unsigned()->default(1);
			$table->foreign('customer_id')->references('id')->on('customers');

			$table->string('request_services', 200);
			
			$table->integer('company_sector_id')->unsigned()->default(1);
			$table->foreign('company_sector_id')->references('id')->on('company_sectors');

			$table->integer('order_status_id')->unsigned()->default(1);
			$table->foreign('order_status_id')->references('id')->on('order_statuses');

			$table->integer('user_id')->unsigned()->default(1);
			$table->foreign('user_id')->references('id')->on('users');
            
            $table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}
}
