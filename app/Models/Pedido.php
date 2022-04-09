<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Direccion;

class Pedido extends Model
{
    use HasFactory;

    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estado_pedido',
        'direccion_id',
    ]; 
    

    /**
     * Relacion de muchos a muchos -> creará una tabla pivote intermedia: pedidos_productos
     * Un producto pertenece a varios pedidos
     * Un pedido tiene varios productos
     */
    public function productos(){
        return $this->belongsToMany(Producto::class)->withPivot('unidades');//->withTimestamps();
    }


    /**
     * Relacion de 1 a muchos
     * Un Pedido tiene 1 direccion
     * Una direccion pertenece a varios pedidos
     */
    public function direccion(){
        return $this->hasOne(Direccion::class);
    }

}
