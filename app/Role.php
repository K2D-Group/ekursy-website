<?php namespace App;


/**
 * App\Role
 *
 * @property integer $id
 * @property string $str_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereStrId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User')->withTimestamps([] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission')->withTimestamps([] $permissions
 */
class Role extends \KDuma\Permissions\Models\Role {



}
