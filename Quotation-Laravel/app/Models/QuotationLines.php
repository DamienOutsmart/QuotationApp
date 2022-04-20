<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quotationLines extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'contents_id',
        'created_at',
        'updated_at',
        'quotation_id'
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

}
