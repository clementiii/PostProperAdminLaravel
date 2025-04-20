<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;

    protected $table = 'user_accounts';

    protected $fillable = [
        'id', 'firstName', 'lastName', 'username', 'age', 'gender', 
        'adrHouseNo', 'adrZone', 'adrStreet', 'birthday', 'password', 
        'user_profile_picture', 'user_valid_id', 'user_valid_id_back',
        'status', 'last_active', 'verified_at', 'rejected_at'
    ];

    protected $dates = [
        'verified_at',
        'rejected_at',
        'created_at',
        'last_active'
    ];
    
    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstName} {$this->lastName}";
    }
    
    /**
     * Get the messages associated with the user.
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    
    /**
     * Get the user's profile picture.
     *
     * @return string
     */
    public function getProfilePictureUrl()
    {
        if (empty($this->user_profile_picture)) {
            return null;
        }
        
        // If it's already a full URL (Cloudinary or other external source)
        if (filter_var($this->user_profile_picture, FILTER_VALIDATE_URL)) {
            return $this->user_profile_picture;
        }
        
        // If it starts with 'storage/' or '/storage/'
        if (strpos($this->user_profile_picture, 'storage/') === 0 || strpos($this->user_profile_picture, '/storage/') === 0) {
            return asset($this->user_profile_picture);
        }
        
        // Fallback to the full asset path
        return asset('storage/' . ltrim($this->user_profile_picture, '/'));
    }
    
    /**
     * Get the user's valid ID front image.
     *
     * @return string
     */
    public function getValidIdUrl()
    {
        if (empty($this->user_valid_id)) {
            return null;
        }
        
        // If it's already a full URL (Cloudinary or other external source)
        if (filter_var($this->user_valid_id, FILTER_VALIDATE_URL)) {
            return $this->user_valid_id;
        }
        
        // If it starts with 'storage/' or '/storage/'
        if (strpos($this->user_valid_id, 'storage/') === 0 || strpos($this->user_valid_id, '/storage/') === 0) {
            return asset($this->user_valid_id);
        }
        
        // Fallback to the full asset path
        return asset('storage/' . ltrim($this->user_valid_id, '/'));
    }
    
    /**
     * Get the user's valid ID back image.
     *
     * @return string
     */
    public function getValidIdBackUrl()
    {
        if (empty($this->user_valid_id_back)) {
            return null;
        }
        
        // If it's already a full URL (Cloudinary or other external source)
        if (filter_var($this->user_valid_id_back, FILTER_VALIDATE_URL)) {
            return $this->user_valid_id_back;
        }
        
        // If it starts with 'storage/' or '/storage/'
        if (strpos($this->user_valid_id_back, 'storage/') === 0 || strpos($this->user_valid_id_back, '/storage/') === 0) {
            return asset($this->user_valid_id_back);
        }
        
        // Fallback to the full asset path
        return asset('storage/' . ltrim($this->user_valid_id_back, '/'));
    }
}