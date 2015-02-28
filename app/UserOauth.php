<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserOauth
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $social_provider
 * @property string $social_id
 * @property string $social_data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\UserOauth whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserOauth whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserOauth whereSocialProvider($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserOauth whereSocialId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserOauth whereSocialData($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserOauth whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserOauth whereUpdatedAt($value)
 */
class UserOauth extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_oauth';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['social_provider','social_id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'social_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

}
