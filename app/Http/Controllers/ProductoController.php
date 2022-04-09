<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

use App\Models\Producto;

class ProductoController extends Controller

{

    /**
     * @author demateu
     * Muestra la página de recursos: recursos + filtros
     */
    public function index(){

        //return $this->showAll(Recurso::activo()->get());
        //$recursos = $this->showAll(Recurso::activo()->get());
        //$recursos = $this->showAll(Recurso::all()->toQuery());

        $pedidos = Pedido::all();

        return view('recursos.index')->with([
            'pedidos' => $pedidos,
        ]);
    }


    /**
     * @author demateu
     * 
     * Ficha de producto del recurso
     * Recibe el slug del producto en lugar del id
     */
    public function show(Producto $recurso){
        return view('recursos.mostrar')->with([
            'recurso' => $recurso,
        ]);
    }



    public function index1(){

        //$subcategorias = Subcategoria::all();
        $categorias = Categoria::all();
        //PAGINATE
        $recursosActivos = Producto::activo()->paginate(3);
        //$recursosActivos = Recurso::activo()->get();
        //activo() será un scope definido en el modelo Recurso; equivale a: $recursosActivos = Recurso::where('status', 'activo')->get();
        //activo() es un filtrado para que solo muestre los recursos activos; se le podria encadenar lo que necesitemos: otro scope, o un where, etc

        return view('recursos.index')->with([
            'recursos' => $recursosActivos,
            //'subcategorias' => $subcategorias,
            'categorias' => $categorias,
        ]);
    }

    public function index2(){
        //$filter_data = 'filter';//musica,mates
        //$sort_by = 'sort_by';

        //$sorts = [];//declarem array on aniran tots els criteris d'ordenacio

        //dd($request->$sort_by);//precio, titulo..
        //dd($request->$filter_data);//mates, musica..

        //$subcategorias = Subcategoria::all();
        $categorias = Categoria::all();

        //si existe 'filter' llamar a filterData() 1ero y que devuelva objeto
        //si no existe 'filter' o ya tenemos el resultado, llamar a sortBy() y que devuelva un objeto
        //$collection = $this->filterData($collection);
        //$collection = $this->sortData($collection);
        //$recursos = Recurso::activo()->get();//Illuminate\Database\Eloquent\Collection 
        //$recursos = $this->filterData($recursos, $filtros);

        //$recursos = Recurso::activo()->paginate(3); -> ESTE FUNCIONA
        //$recursos = Recurso::all();

        $recursos = $this->filterData();
        //despues de filtrar que ordene -> groupBy()?
        $recursos = $this->sortData($recursos);
        //dd($recursos->paginate(3)); //OJO Illuminate\Pagination\LengthAwarePaginator
        //aqui
        //$qb = $qb->activo()->get();
        $recursos = $recursos->paginate(2);
        //dd($qb);
        //PAGINATE
        
        //$recursosActivos = Recurso::activo()->get();
        //activo() será un scope definido en el modelo Recurso; 
            //equivale a: $recursosActivos = Recurso::where('status', 'activo')->get();
        //activo() es un filtrado para que solo muestre los recursos activos; 
            //se le podria encadenar lo que necesitemos: otro scope, o un where, etc

        return view('recursos.index')->with([
            'recursos' => $recursos,
            //'subcategorias' => $subcategorias,
            'categorias' => $categorias,
        ]);
    }



    /**
     * Recibe la colección y es filtrada por diferentes atributos: 1 o +
     */
    //protected function filterData(){
        /*
        $subcategorias = Subcategoria::all();
        $filtros_string = [];
        $filtros_id = [];
        */
        //dd(request()->query());//"sort_by" => "titulo"
        
        //si la url contiene ?filtrar=x, pasa cada uno de los valores en un array
        /*
        if(request()->filtrar){
            $filtros_string = explode(",", request()->filtrar);
        }*/

        //si el array $filtros no está vacío, pasa los valores de slug a id -> consulta a la tabla subcategorias
        /*
        if(count($filtros_string)>0){
            foreach($filtros_string as $filtro){
                //echo "<strong>$filtro</strong><br>";
                foreach($subcategorias as $subcategoria){
                    //echo "$subcategoria->id<br>";
                    if($subcategoria->slug == $filtro){
                        //echo "$subcategoria->id<br>";//esta donant l'id en funcio del slug que es passa per filter
                        //CREAR NUEVO ARRAY CON VALORES id EN LUGAR DE strings
                        array_push($filtros_id, $subcategoria->id);
                        //dame los recursos de la subcategoria con id='x'
                        //AQUI NO SOLO TIENE QUE SER CARGAR SINO AÑADIR (por si hay mas de un filtro)
                        //$recursos = Subcategoria::find($subcategoria->id)->recursos()->where('subcategoria_id', $subcategoria->id)->get();
                        //dd($recursos);//SI!!!
                    }
                }

            }            
        }*/

        //$qb = DB::table('recursos') //Illuminate\Support\Collection
            //->join('recurso_subcategoria', 'recursos.id', '=', 'recurso_subcategoria.recurso_id')

        /*AQUI HI HA UN FALLO*/
        /*
        $qb = Recurso::join('recurso_subcategoria', 'recursos.id', '=', 'recurso_subcategoria.recurso_id') //Illuminate\Database\Eloquent\Collection
            ->select('recursos.*')->distinct();
        */

        /*
        $qb = $recursos->join('recurso_subcategoria', 'recursos.id', '=', 'recurso_subcategoria.recurso_id') //Illuminate\Database\Eloquent\Collection
            ->select('recursos.*')->distinct();
        */
        /*
        if(count($filtros_id)>0){
            foreach($filtros_id as $subcategoria){
                if(count($filtros_id) == 1){
                    $qb->where('recurso_subcategoria.subcategoria_id', $subcategoria);
                }
                if(count($filtros_id) > 1){
                    $qb->orWhere('recurso_subcategoria.subcategoria_id', $subcategoria);
                }
            }
        }*/

        /*
        if(!request()->filtrar){
            $qb = Recurso::activo();
            return $qb;
        }*/

        //return $qb;//para pasar el activo()en index tiene que devolverlo así
    //}

    /**
     * Ordena los elementos
     * Si la peticion tiene el valor 'sort_by' recojerá el nombre del atributo
     * Este método será usado por el showAll()
     * 
     * Retornara la coleccion tanto en caso de haberla ordenado como no
     * La coleccion se ordenara unicamente si recibe un parametro en la URL que llamaremos 'sort_by'
     */
    /*
    protected function sortData($qb){
        
        //$qb = $qb;//test
        if(request()->has('sort_by')){
            $criterio_busqueda = request()->sort_by;
            //ver la forma de haga swith: desc - asc cada vez que toque el link
            $qb = $qb->orderBy($criterio_busqueda, 'asc');
        }
        
        return $qb;
    }*/






}

