<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMaterialSuppliesTable.
 */
class CreateMaterialSuppliesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('material_supplies', function(Blueprint $table) {
            $table->increments('id');

			$table->integer('material_id')->unsigned()->default(1);
			$table->foreign('material_id')->references('id')->on('materials');
			
			$table->integer('warehouse_id')->unsigned()->default(1);
			$table->foreign('warehouse_id')->references('id')->on('warehouses');

			$table->float('qty')->unsigned()->default(0);
			
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
		Schema::drop('material_supplies');
	}
}
