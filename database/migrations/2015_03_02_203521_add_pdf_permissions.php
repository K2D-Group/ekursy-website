<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPdfPermissions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        PermissionsManager::createPermission('course.pdf', 'Allow downloading PDF files.');
        PermissionsManager::createPermission('course.pdf.booklet', 'Allow downloading PDF BookLet.');
        PermissionsManager::createPermission('course.pdf.whitelabel', 'Allow downloading WhiteLabel version of PDF.');

        PermissionsManager::attach(['admin', 'copywriter', 'user'], [
            'course.pdf',
        ]);
        PermissionsManager::attach(['admin', 'copywriter'], [
            'course.pdf.booklet',
        ]);
        PermissionsManager::attach(['admin'], [
            'course.pdf.whitelabel',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        PermissionsManager::deletePermission('course.pdf', 'Allow downloading PDF files.');
        PermissionsManager::deletePermission('course.pdf.booklet', 'Allow downloading PDF BookLet.');
        PermissionsManager::deletePermission('course.pdf.whitelabel', 'Allow downloading WhiteLabel version of PDF.');
	}

}
