<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_city',
        'customer_email',
        'customer_first_name',
        'customer_house_number',
        'customer_last_name',
        'customer_postal_code',
        'customer_street',
        'status',
    ];

    public function quotationLines(){
        return $this->hasMany(quotationLines::class);
    }
}
