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
		$user = User::firstOrNew(['email'=>'krystian@muzik.pl']);
		$user->name = 'Administrator';
		$user->emailConfirmed = true;
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
		$user = User::where('email', 'krystian@muzik.pl')->first();
		$user->delete();
	}

}
