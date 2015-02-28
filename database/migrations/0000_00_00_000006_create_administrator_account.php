<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use KDuma\Permissions\Models\Role;

class CreateAdministratorAccount extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$user = User::firstOrNew(['email'=>'root@localhost']);
		$user->name = 'Administrator';
		$user->password = bcrypt('1234');
		$user->save();


		$role = Role::where('str_id', 'admin')->firstOrFail();
		$user->roles()->sync([$role->id], false);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$user = User::where('email', 'root@localhost')->first();
		$user->delete();
	}

}
