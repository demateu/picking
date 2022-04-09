<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Pedido;

class Producto extends Model
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
        //'precio',
    ]; 
    

    /**
     * Relacion de muchos a muchos -> creará una tabla pivote intermedia: pedidos_productos
     * Un producto pertenece a varios pedidos
     * Un pedido tiene varios productos
     */
    public function pedidos(){
        return $this->belongsToMany(Pedido::class)->withPivot('unidades');//->withTimestamps();
    }
 

}
