<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    use HasFactory;

    protected $table = 'incident_reports'; // ✅ Match this to your actual table name

    protected $fillable = [
        'id', 'name', 'title', 'description', 'date_submitted', 'status',
    ];
}
