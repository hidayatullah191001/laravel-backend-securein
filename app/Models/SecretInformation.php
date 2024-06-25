<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecretInformation extends Model
{
    use HasFactory;
    protected $with = ['user', 'category', 'label'];    
    protected $fillable = [
        'user_id',
        'category_id',
        'label_id',
        'title',
        'account',
        'password',
        'additional',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }
}
