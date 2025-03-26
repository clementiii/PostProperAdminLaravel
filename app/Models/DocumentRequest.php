<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $table = 'document_requests'; // Assuming your table name is 'document_requests'

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
    ];

}