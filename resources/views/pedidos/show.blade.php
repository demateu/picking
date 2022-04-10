@extends('app')

@section('content')

<div class="card">
    <div class="card-header">
        <h1>Detalle del pedido {{ $pedido->id }}</h1>
    </div>

    <header class="p-3 bg-dark text-white sticky-top">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
              <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <i class="fa-solid fa-arrow-turn-down-left" style="color: whitesmoke;"></i>
                PANEL DE ADMINISTRACION
              </a>  
              <p><i class="fa-solid fa-arrow-turn-down-left" style="color: red;"></i></p>
            </div>
          </div>
        </header>

    <form method="POST" action="{{ route('pedidos.update', $pedido) }}">
            @csrf  
            @method('PUT') 

        <div class="card-body col-8 mx-auto">
            <h2><i class='fab fa-angellist'></i> Revisa y actualiza el estado del pedido</h2>

            {{-- id --}}
            <div class="form-row my-2">
                <label><strong>Identificador del pedido</strong></label>
                <input class="form-control" type="text" value="{{ old('id') ?? $pedido->id }}" placeholder="$pedido->id" disabled/>
            </div>
            {{-- fecha del pedido --}}
            <div class="form-row my-2">
                <label><strong>Fecha de creación y hora del pedido</strong></label>
                <input class="form-control" type="text" value="{{ old('created_at') ?? $pedido->created_at }}" placeholder="$pedido->created_at" disabled/>
            </div>
            {{-- Nombre del envío --}}
            <div class="form-row my-2">
                <label><strong>Nombre del envío</strong></label>
                <input class="form-control" type="text" value="{{ old('nombre') ?? $pedido->direccion->nombre }}" placeholder="$pedido->direccion->nombre" disabled/>
            </div>
            {{-- Apellidos del envío --}}
            <div class="form-row my-2">
                <label><strong>Apellidos del envío</strong></label>
                <input class="form-control" type="text" value="{{ old('apellidos') ?? $pedido->direccion->apellidos }}" placeholder="$pedido->direccion->apellidos" disabled/>
            </div>
            {{-- Direccion del envío --}}
            <div class="form-row my-2">
                <label><strong>Dirección del envío</strong></label>
                <input class="form-control" type="text" value="{{ old('direccion') ?? $pedido->direccion->direccion }}" placeholder="$pedido->direccion->direccion" disabled/>
            </div>
            {{-- Pais del envío --}}
            <div class="form-row my-2">
                <label><strong>País del envío</strong></label>
                <input class="form-control" type="text" value="{{ old('pais') ?? $pedido->direccion->pais }}" placeholder="$pedido->direccion->pais" disabled/>
            </div>
            {{-- Estado del pedido --}}
            <div class="form-row my-2">
                <label><strong>Estado del padido</strong></label>
                <input class="form-control" type="text" value="{{ old('estado_pedido') ?? $pedido->estado_pedido }}" placeholder="$pedido->estado_pedido" required/>
            </div>
            <div class="form-row">
                <label>Activar/desactivar</label>
                <select class="custom-select" name="estado_pedido" required>
                    <option {{ old('estado_pedido') == 'selected' ? 'pago aceptado' : ($pedido->estado_pedido == 'pago aceptado' ? 'selected' : '') }} value="pago aceptado">
                        Pago aceptado
                    </option>
                    <option {{ old('estado_pedido') == 'selected' ? 'preparacion en proceso' : ($pedido->estado_pedido == 'preparacion en proceso' ? 'selected' : '') }} value="preparacion en proceso">
                        Preparación en proceso
                    </option>
                    <option {{ old('estado_pedido') == 'selected' ? 'pago rechazado' : ($pedido->estado_pedido == 'pago rechazado' ? 'selected' : '') }} value="pago rechazado">
                        Pago rechazado
                    </option>
                    <option {{ old('estado_pedido') == 'selected' ? 'enviado' : ($pedido->estado_pedido == 'enviado' ? 'selected' : '') }} value="enviado">
                        Enviado
                    </option>
                </select>
            </div>

            <div class="form-row my-2">
                <button type="submit" class="btn btn-outline-primary btn col-12 my-3">
                    <i class="fas fa-plus"></i> Actualizar pedido
                </button>
            </div>  
        </div>
    </form>

</div>



@endsection