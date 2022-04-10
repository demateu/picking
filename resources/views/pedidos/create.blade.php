@extends('app')

@section('content')

<div class="card">
    <div class="card-header">
        <h1>Crea un pedido nuevo</h1>
    </div>

    <header class="p-3 bg-dark text-white sticky-top">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            PANEL DE ADMINISTRACION
          </a>  
        </div>
      </div>
    </header>


    <div class="card-body">

        @if (session('errors'))
        <div class="alert alert-danger" role="alert">
            <span>{{ session('errors') }}</span>
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('pedidos.store') }}">
            @csrf

            <div class="card-header">
                <h2>Datos de envío</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- nombre --}}
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre') }}" required/>
                    </div>        
                    {{-- apellidos --}}
                    <div class="col-md-6">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" required/>
                    </div>
                </div>
                <div class="row">
                    {{-- direccion --}}
                    <div class="col-6">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" name="direccion" id="direccion" placeholder="C Major, 12, 4, 3. Reus" value="{{ old('direccion') }}" required/>
                    </div>
                    {{-- pais --}}
                    <div class="col-md-6">
                        <label for="pais" class="form-label">País</label>
                        <input type="text" class="form-control" name="pais" id="pais" value="{{ old('pais') }}" required/>
                    </div>
                </div>
            </div>


            <div class="card-header">
                <h2>Productos del pedido</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- productos --}}
                    <div class="col-12">

                        <div class="row">
                            @foreach ($productos as $producto)
                                <div class="col-4">
                                <input name="producto[]" id="{{ $producto->id }}" type="checkbox" value="{{ $producto->id }}">
                                {{ $producto->nombre }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-outline-primary" style="width: 100%">Crear</button>
            </div>

        </form>

    </div>
</div>



@endsection