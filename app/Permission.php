<?php namespace App;


/**
 * App\Permission
 *
 * @property integer $id
 * @property string $str_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Permission whereStrId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Permission whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role')->withTimestamps([] $roles
 */
class Permission extends \KDuma\Permissions\Models\Permission {


}
