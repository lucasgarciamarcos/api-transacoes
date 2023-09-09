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
    protected $primaryKey = 'conta_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saldo'
    ];

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
        $attributes = [
            'saldo' => $conta->saldo,
        ];

        $validator = Validator::make($attributes, [
            'saldo' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
