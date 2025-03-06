<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DocumentRequest extends Model
{
    use HasFactory;


    protected $table = 'document_requests'; // Table name


    protected $fillable = [
        'id',
        'document_type',
        'name',
        'status',
        'address',
        'quantity',
        'date_requested',
        'tin',
        'ctc_number',
        'price',
    ];
}


