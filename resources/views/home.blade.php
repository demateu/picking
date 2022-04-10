@extends('app')

@section('content')

<div class="card">
    <div class="card-header">
        <h1>Picking</h1>
    </div>

    @include('includes.header')

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
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td></a>
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

                        <td>
                            <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i> Ver</a>
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