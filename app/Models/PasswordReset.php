<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-10-27
 * Time: 9:10
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{

    protected $table = 'password_resets';
    protected $primaryKey = 'email';

    const UPDATED_AT = 'created_at';
}