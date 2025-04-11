<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $table = 'document_requests'; // Assuming your table name is 'document_requests'

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'Id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'Name',
        'Address',
        'Age',
        'birthday',
        'PlaceOfBirth',
        'Alias',
        'Citizenship',
        'Occupation',
        'Gender',
        'CivilStatus',
        'LengthOfStay',
        'DocumentType',
        'Purpose',
        'TIN_No',
        'CTC_No',
        'Quantity',
        'Status',
        'rejection_reason',
        'DateRequested',
        'date_approved',
        'valid_id_front',
        'valid_id_back',
        'pickup_status'
    ];

    /**
     * The attributes that should be cast.
     *
     * Tells Laravel how to treat the 'birthday' column.
     * Assuming the format in the DB is consistently 'MM-DD-YY'
     *
     * @var array<string, string>
     */
    protected $casts = [
        //'birthday' => 'date:m-d-y', // Tells Laravel to expect 'm-d-y' format
        'DateRequested' => 'datetime', // Good practice to cast other date/time fields too
        'date_approved' => 'datetime', // Good practice to cast other date/time fields too
        'Status' => 'string',
        'pickup_status' => 'string',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'DateRequested',
        'date_approved',
    ];

    /**
     * Set the Status attribute.
     *
     * @param string $value
     * @return void
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['Status'] = strtolower($value);
    }

    /**
     * Set the pickup_status attribute.
     *
     * @param string $value
     * @return void
     */
    public function setPickupStatusAttribute($value)
    {
        $this->attributes['pickup_status'] = strtolower($value);
    }

    /**
     * Get the Status attribute.
     *
     * @param string $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * Get the pickup_status attribute.
     *
     * @param string $value
     * @return string
     */
    public function getPickupStatusAttribute($value)
    {
        return strtolower($value);
    }
}