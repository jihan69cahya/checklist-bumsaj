<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryValue extends Model
{
    use HasFactory;

    protected $fillable = ['checklist_category_id', 'value_code', 'value_description'];

    public function category()
    {
        return $this->belongsTo(ChecklistCategory::class, 'checklist_category_id');
    }
}
