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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (is_numeric($this->saldo)) {
            $this->saldo = number_format($this->saldo, 2, '.', '');
        }
    }

    public static function getRules()
    {
        return [
            'conta_id'  => 'unique:contas',
            'saldo'     => 'required|numeric|min:0',
        ];
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
        $validator = Validator::make($conta->toArray(), self::getRules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
