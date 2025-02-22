<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'item_name', 'description'];

    public function checklist_category()
    {
        return $this->belongsTo(ChecklistCategory::class);
    }

    public function checklist_subcategory()
    {
        return $this->belongsTo(ChecklistSubcategory::class);
    }
}
