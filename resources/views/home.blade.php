@extends('app')

@section('content')

<div class="card">
    <div class="card-header">
        <h1>Picking</h1>
        Test
        {{ Form::open(['route' => 'pedidos.index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
            <div class="form-group">
                {{ Form::text('estado_pedido', null, ['class' => 'form-control', 'placeholder' => 'Estado del pedido']) }}
            </div>
            <div class="form-group">
                {{ Form::text('pais', null, ['class' => 'form-control', 'placeholder' => 'Pais']) }}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
        {{ Form::close() }}
    </div>

    <header class="p-3 bg-dark text-white">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                LOGO
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
              <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
              <li><a href="#" class="nav-link px-2 text-white">Features</a></li>
              <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
              <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
              <li><a href="#" class="nav-link px-2 text-white">About</a></li>
            </ul>
    
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" class="form-control form-control-dark" placeholder="Estado del pedido..." aria-label="Search">
            </form>
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" class="form-control form-control-dark" placeholder="Pais..." aria-label="Search">
            </form>
    
            <div class="text-end">
                {{-- 
              <button type="button" class="btn btn-outline-light me-2">Login</button>
              <button type="button" class="btn btn-warning">Sign-up</button>
               --}}
                <a href="{{route('pedidos.create')}}" class="btn btn-outline-primary btn">
                    <i class="fas fa-plus"></i> Crear pedido
                </a>
            </div>
          </div>
        </div>
    </header>

    <div class="card-body">
        {{-- mensajes: succes, errors... --}}
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            <span>{{ session('error') }}</span>
        </div>
        @endif
        {{-- !mensajes: succes, errors... --}}

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Fecha</th>
                    <th>Nombre y apellidos</th>
                    <th>Dirección de envío</th>
                    <th>País</th>
                    <th>Productos</th>
                    <th>Estado del pedido</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->created_at }}</td>

                        <td>{{ $pedido->direccion->nombre }} {{ $pedido->direccion->apellidos }}</td>
                        <td>{{ $pedido->direccion->direccion }}</td>
                        <td>{{ $pedido->direccion->pais }}</td>
                        <td>
                            @foreach ($pedido->productos as $producto)
                                {{ $producto->nombre }} x {{ $producto->pivot->unidades }}<br>
                            @endforeach
                        </td>
                        <td>{{$pedido->estado_pedido}}</td>
                        
                        <td width="10px">
                            <a href="#" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i> Editar</a>
                        </td>
                        <td width="10px">
                            <form action="#" method="POST">
                                @csrf
                                @method('delete')

                                <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        
        <!--AÑADO LA PAGINACION-->
        {{ $pedidos->render() }}
        {{-- 
        <div class="clearfix"></div>
        {{ $pedidos->links() }} 
         --}}

    </div>
</div>



@endsection