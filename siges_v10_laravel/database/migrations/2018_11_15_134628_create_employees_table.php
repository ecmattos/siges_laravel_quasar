<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateEmployeesTable.
 */
class CreateEmployeesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table) {
            $table->increments('id');

			$table->string('cpfcnpj', 14)->nullable();
			$table->string('code', 10)->nullable();
			$table->string('name', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('neighborhood', 30)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('state', 2)->nullable();
			$table->string('phone', 11)->nullable();
            $table->string('mobile', 11)->nullable();
            $table->string('email', 50)->nullable();
			$table->string('comments', 200)->nullable();
			
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
		Schema::drop('employees');
	}
}
