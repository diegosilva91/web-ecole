<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionPurchaseAssistant extends Model
{
    protected $table = 'promotion_purchase_assistant';
    protected $fillable = ['promotion_purchase_id', 'user_assistant_id'];

    public function promotionsAssistantUsers()
    {
        return $this->belongsToMany("App\User", 'user_assistant', 'id', 'user_id', 'user_assistant_id', 'id');
    }
}
