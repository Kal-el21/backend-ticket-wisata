<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'criteria',
        'favorite',
        'status',
        'stock',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => $image ? asset('/storage/products' . $image) : asset('/images/no-image.png'),
        );
    }

        // Mutator untuk menyimpan format "YYYY-MM-DD"
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor untuk menampilkan format "DD-MM-YYYY"
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
