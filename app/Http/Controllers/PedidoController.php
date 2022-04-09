<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;//import para transacciones (BBDD)

class PedidoController extends Controller
{

    /**
     * @author demateu
     * Muestra los pedidos
     */
    public function index(Request $request){

        //return $this->showAll(Recurso::activo()->get());
        //$recursos = $this->showAll(Recurso::activo()->get());
        //$recursos = $this->showAll(Recurso::all()->toQuery());
        $estado_pedido = $request->get('estado_pedido');
        $pais = $request->get('pais');

        $pedidos = Pedido::orderBy('estado_pedido', 'ASC')
            ->estado($estado_pedido)
            ->pais($pais)
            ->paginate(5);
        
        //para no perder los resultados del filtrado con la paginación
        $pedidos->appends([
            'estado_pedido' => $estado_pedido, 'pais' => $pais]);

        return view('home')->with([
            'pedidos' => $pedidos,
        ]);
    }


    /**
     * Retorna una vista con los detalles del pedido
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function create()
    public function crear()
    {
        $carrito = $this->carritoService->getFromCookie();

        if(!isset($carrito) || ($carrito->recursos->isEmpty() && $carrito->pildoras->isEmpty())){
            return redirect()
                ->back()
                ->withErrors("Tu carrito está vacío!");
        }

        return view('pedidos.crear')->with([
            'carrito' => $carrito,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Debe haber un usuario autenticado cuando se ejecute esta funcion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //ponemos las acciones dentro de una transaccion
        return DB::transaction(function () use($request) {
            $user = $request->user();
            //creamos un pedido asociado al user identificado
            $pedido = $user->pedidos()->create([
                'status' => 'pendiente',
            ]);
    
            //enviar los datos/productos del carrito al pedido
            $carrito = $this->carritoService->getFromCookie();
            $carrito_id = $carrito->id;
    
            //SI NO QUEREMOS AÑADIR CANTIDAD:
            //$carrito->recursos()->attach($carrito->recursos);
            //..y pildoras?
            //SINO > haremos una lista del id de los productos con la cantidad
                //Recursos
            $recursosCarritoConCantidad = $carrito //no sé porque salta este error..
                                        ->recursos
                                        ->mapWithKeys(function($recurso){
                                            $element1[$recurso->id] = [
                                                'cantidad'=> $recurso->pivot->cantidad,
                                                'producto_tipo' => 'App\Models\Recurso',
                                                'recurso_id' => $recurso->id,
                                                'pildora_id'=> NULL,
                                            ];
                                                
                                            return $element1;
                                        });
    
            $arrayRecursos = $recursosCarritoConCantidad ->toArray();
    
                //Pildoras
            $pildorasCarritoConCantidad = $carrito //no sé porque salta este error..
                                        ->pildoras
                                        ->mapWithKeys(function($pildora){
                                            $element2[$pildora->id] = [
                                                'cantidad'=> $pildora->pivot->cantidad,
                                                'producto_tipo' => 'App\Models\Pildora',
                                                'pildora_id' => $pildora->id,
                                                'recurso_id' => NULL,
                                            ];
                    
                                            return $element2;
                                        });
                                        
            $arrayPildoras = $pildorasCarritoConCantidad ->toArray();
            //$resultado = array_merge($array1, $array2);
            $arrayPedidos = $arrayRecursos + $arrayPildoras;
    
            //$pedido->recursos()->attach($recursosCarritoConCantidad ->toArray());
            $pedido->recursos()->attach($arrayPedidos);
            //dd($pedido);
            return redirect()->route('pedidos.pagos.crear', ['pedido' => $pedido]);            
        });

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    /*
    public function show(Pedido $pedido)
    {
        //
    }
    */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    /*
    public function edit(Pedido $pedido)
    {
        //
    }
    */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    /*
    public function update(Request $request, Pedido $pedido)
    {
        //
    }
    */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(Pedido $pedido)
    {
        //
    }
    */


    /*
    public function quitoProductoPedido(Request $request, $id_producto, Carrito $carrito )
    {
        $cantidad = ($request->cantidad);//cantidad que tiene el producto que se quiere eliminar
        $tipo_producto = $request->tipo;
        $id = $request->id; //REC-n

        if($tipo_producto === 'App\Models\Pildora'){
            $carrito->pildoras()->detach($id_producto);//ahora esta quitando todos los de este id, sin contarlos
        }
        if($tipo_producto === 'App\Models\Recurso'){
            $carrito->recursos()->detach($id_producto);//ahora esta quitando todos los de este id, sin contarlos
        }
        
        $cookie = $this->carritoService->crearCookie($carrito);
        return redirect()->back()->cookie($cookie);
    }  
    */  



}
