<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = ['checklist_category_id', 'item_name', 'description'];

    public function category()
    {
        return $this->belongsTo(ChecklistCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(ChecklistSubcategory::class);
    }
}
