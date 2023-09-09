<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class Conta extends Model
{    
    use HasFactory;

    protected $table = 'contas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saldo', 'conta_id'
    ];

    public static $rules = [
        'conta_id' => 'unique:contas',
        'saldo' => 'required|numeric|min:0',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->saldo = number_format($this->saldo, 2);
    }

    /**
     * Método para criar uma nova conta e validar os atributos.
     *
     * @param Conta $conta
     * @return Conta
     */
    public static function criar(Conta $conta)
    {
        self::validarAtributos($conta);

        return $conta->save() ? $conta : null;
    }

    /**
     * Método para validar os atributos da conta.
     *
     * @param Conta $conta
     * @return void
     * @throws ValidationException
     */
    public static function validarAtributos(Conta $conta)
    {
        $validator = Validator::make($conta->toArray(), self::$rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}