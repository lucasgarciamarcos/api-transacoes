<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class Transacao extends Model
{
    use HasFactory;
    
    protected $table = 'transacoes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conta_id', 'valor', 'forma_pagamento'
    ];
    
    public static $rules = [
        'conta_id' => 'required',
        'valor' => 'required|numeric',
        'forma_pagamento' => 'required|string',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $validator = Validator::make($attributes, self::$rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public static function formasPagamento()
    {
        return ['C', 'D', 'P'];
    }
}
