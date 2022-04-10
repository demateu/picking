<header class="p-3 bg-dark text-white sticky-top">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li>
              <a href="{{ route('pedidos.index') }}" class="nav-link px-2 text-white">PANEL DE ADMINISTRACION</a>
            </li>
        </ul>
            
            {{ Form::open(['route' => 'pedidos.index', 'method' => 'GET', 'class' => 'form-inline pull-right d-flex flex-row bd-highlight']) }}
            <div class="form-group mx-1">
                {{ Form::text('estado_pedido', null, ['class' => 'form-control', 'placeholder' => 'Estado del pedido...']) }}
            </div>
            <div class="form-group mx-1">
                {{ Form::text('pais', null, ['class' => 'form-control', 'placeholder' => 'Pais...']) }}
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-default">
                    <i class="fa-solid fa-rotate" style="color: whitesmoke;"></i>
                    </a>
                </button>
            </div>
            {{ Form::close() }}

        <div>
            <a href="{{route('pedidos.create')}}" class="btn btn-outline-primary btn">
                <i class="fas fa-plus"></i> Crear pedido
            </a>
        </div>

      </div>
    </div>
</header>