<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\CourseLesson
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $last_update
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\CourseLesson whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseLesson whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseLesson whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseLesson whereLastUpdate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseLesson whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseLesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CourseLesson whereUpdatedAt($value)
 * @property integer $course_id
 * @method static \Illuminate\Database\Query\Builder|\App\CourseLesson whereCourseId($value)
 */
class CourseLesson extends Model {

    use SoftDeletes;
    protected $dates = ['deleted_at', 'last_update'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'name', 'last_update'];

    function course(){
        return $this->belongsTo('\App\Course', 'course_id');
    }
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'need_login' => 'boolean',
        'authors' => 'array',
        'reviewers' => 'array',
        'sources' => 'array',
        'updates' => 'array',
    ];
}
