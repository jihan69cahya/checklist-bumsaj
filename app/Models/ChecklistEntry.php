<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'checklist_category_id',
        'checklist_item_id',
        'period_id',
        'entry_value_id',
        'entry_date',
        'entry_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checklist_category()
    {
        return $this->belongsTo(ChecklistCategory::class);
    }

    public function checklist_item()
    {
        return $this->belongsTo(ChecklistItem::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function entryValue()
    {
        return $this->belongsTo(EntryValue::class);
    }
}
