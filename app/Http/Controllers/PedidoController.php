<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Direccion;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DateTime;

use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{

    /**
     * @author demateu
     * Muestra los pedidos
     */
    public function index(Request $request){
        $estado_pedido = $request->get('estado_pedido');
        $pais = $request->get('pais');

        $pedidos = Pedido::orderBy('estado_pedido', 'ASC')
            ->estado($estado_pedido)
            ->pais($pais)
            ->paginate(10);
        
        //para no perder los resultados del filtrado con la paginación
        $pedidos->appends([
            'estado_pedido' => $estado_pedido, 'pais' => $pais]);

        return view('home')->with([
            'pedidos' => $pedidos,
        ]);
    }


    /**
     * Retorna una vista con los detalles del pedido
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('pedidos.create')->with([
            'productos' => Producto::all(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PedidoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use($request) {

            $validator = Validator::make($request->all(), [
                'nombre' => ['required','max:255'],
                'apellidos' => ['required','max:255'],
                'direccion' => ['required','max:255'],
                'pais' => ['required','max:255'],
                'producto' => ['required'],
                //'unidades' => ['nullable'],
                //'estado-pedido' => ['required'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $validated = $validator->validated();


            if($validated){

                //crear direccion del envio
                $direccion = Direccion::create([
                    'nombre' => $validated['nombre'],
                    'apellidos' => $validated['apellidos'],
                    'direccion' => $validated['direccion'],
                    'pais' => $validated['pais'],
                ]);

                //crear pedido
                $pedido = Pedido::create([
                    'direccion_id' => $direccion->id,
                    'created_at' => Carbon::now(),//no guarda el dato
                ]);

                //añadir productos al pedido
                foreach($validated['producto'] as $producto){
                    $pedido->productos()->attach([
                        //'unidades' => mt_rand(1, 3),
                        //'pedido_id' => mt_rand(1, 10),
                        'producto_id' => $producto,
                    ]);
                }
            }

            return redirect('/')->withSuccess("Pedido {$pedido->id} creado!");

        }, 5); 

    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        return view('pedidos.show')->with([
            'pedido' => $pedido,
        ]);
    }
    

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
     * @author demateu
     * 
     * Si se recibe el estado del pedido, actualiza el campo
     * en el pedido que recibe por parámetro
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        return DB::transaction(function () use($request, $pedido) {

        if($request->has('estado_pedido')){
            $pedido->estado_pedido = $request->get('estado_pedido');
            $pedido->direccion_id = $pedido->direccion_id;
            $pedido->updated_at = Carbon::now();
            $pedido->save();
        }

        return redirect('/')->withSuccess("Pedido {$pedido->id} actualizado!");

        }, 5); 
    }
    

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


}
