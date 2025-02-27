<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistSubcategory extends Model
{
    use HasFactory;

    protected $fillable = ['subcategory_name', 'checklist_category_id'];

    public function checklist_items()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function entry_values()
    {
        return $this->hasMany(EntryValue::class);
    }

    public function checklist_category()
    {
        return $this->belongsTo(ChecklistCategory::class);
    }

    public function items()
    {
        return $this->hasMany(ChecklistItem::class);
    }

}
