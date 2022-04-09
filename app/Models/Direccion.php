<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedido;

class Direccion extends Model
{
    use HasFactory;

    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'apellidos',
        'direccion',
        'pais',
        'telefono'
    ]; 
    

    /**
     * Relacion de 1 a muchos
     * Un Pedido tiene 1 direccion
     * Una direccion pertenece a varios pedidos
     */
    public function pedidos(){
        return $this->belongsToMany(Pedido::class);
    }

}
