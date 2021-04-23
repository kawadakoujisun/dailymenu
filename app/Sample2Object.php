<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample2Object extends Model
{
    protected $fillable = ['ui'];
    
    public function setUIValue($value)
    {
        dump($this->ui);
        $this->ui = $value;
        $this->save();
    }
    
    public function incrementUIValue()
    {
        dump($this->ui);
        $this->increment('ui');
    }
}
