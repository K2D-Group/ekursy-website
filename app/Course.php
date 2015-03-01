<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Course
 *
 * @property integer $id
 * @property string $name
 * @property string $last_update
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereLastUpdate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereUpdatedAt($value)
 * @property string $slug
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereSlug($value)
 * @property string $version 
 * @method static \Illuminate\Database\Query\Builder|\App\Course whereVersion($value)
 */
class Course extends Model {

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'name', 'last_update'];
}
