<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class SavedCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'site_name',
        'site_url',
        'username',
        'password',
        'notes',
    ];

    protected $table = 'saved_credentials';

    /**
     * Mutator for site_name - encrypts on save
     */
    public function setSiteNameAttribute($value)
    {
        $this->attributes['site_name'] = Crypt::encryptString($value);
    }

    /**
     * Accessor for site_name - decrypts on retrieve
     */
    public function getSiteNameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    /**
     * Mutator for site_url - encrypts on save
     */
    public function setSiteUrlAttribute($value)
    {
        $this->attributes['site_url'] = Crypt::encryptString($value);
    }

    /**
     * Accessor for site_url - decrypts on retrieve
     */
    public function getSiteUrlAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    /**
     * Mutator for username - encrypts on save
     */
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = Crypt::encryptString($value);
    }

    /**
     * Accessor for username - decrypts on retrieve
     */
    public function getUsernameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    /**
     * Mutator for password - encrypts on save
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    /**
     * Accessor for password - decrypts on retrieve
     */
    public function getPasswordAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    /**
     * Mutator for notes - encrypts on save
     */
    public function setNotesAttribute($value)
    {
        if ($value) {
            $this->attributes['notes'] = Crypt::encryptString($value);
        }
    }

    /**
     * Accessor for notes - decrypts on retrieve
     */
    public function getNotesAttribute($value)
    {
        if ($value) {
            return Crypt::decryptString($value);
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
