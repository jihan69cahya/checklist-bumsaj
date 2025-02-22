<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistCategory extends Model
{
    use HasFactory;
    protected $fillable = ['category_name', 'description'];

    public function checklist_items()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function subcategories()
    {
        return $this->hasMany(ChecklistSubcategory::class, 'category_id');
    }

    public function entry_values()
    {
        return $this->hasMany(EntryValue::class, 'category_id');
    }
}
