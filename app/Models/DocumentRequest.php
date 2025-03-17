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
}