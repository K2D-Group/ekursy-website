<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccessToDevelopBranchPermissions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        PermissionsManager::createPermission('course.devversion', 'Allow access to develop branch version.');

        PermissionsManager::attach(['admin', 'copywriter'], [
            'course.devversion',
        ]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        PermissionsManager::deletePermission('course.devversion', 'Allow access to develop branch version.');
	}

}
