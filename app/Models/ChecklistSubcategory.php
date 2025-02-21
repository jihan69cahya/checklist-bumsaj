<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistSubcategory extends Model
{
    use HasFactory;

    protected $fillable = ['subcategory_name', 'category_id'];

    public function checklist_items()
    {
        return $this->hasMany(ChecklistItem::class);
    }
}
