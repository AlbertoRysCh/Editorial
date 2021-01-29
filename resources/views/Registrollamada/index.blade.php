<style>
    .bootstrap-select>.dropdown-toggle {
    position: relative;
    width: 100%;
    text-align: right;
    white-space: nowrap;
    display: -webkit-inline-box;
    display: -webkit-inline-flex;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    border-color: #0097a7;
    }
    textarea {
        resize: none;
    }
    td {
    white-space: normal !important;
    word-wrap: break-word;
    }
    table {
    table-layout: fixed;
    }
    label.error{ color:red; }
</style>
@endsection
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
            </ol>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">

                       <h3>Registro de Llamadas</h3><br/>

                        <a type="button" href="{{route('registrollamada.create')}}" class="btn botonagregar btn-sm create">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Registro
                        </a>
                    </div>
                    <div class="row">
                    <div class="col-sm-4" style="margin-left: 15px;margin-top: 15px;">
                        <div class="form-group">
                            <div class="input-group">
                            <select class="form-control selectpicker" name="status_llamada_select" id="status_llamada_select" data-live-search="true">
                                <option value="T">ESTADO</option>
                                @forelse($statusllamadas as $items)
                                <option value="{{$items->id}}"> {{$items->nombre}}</option>
                                @empty
                                Registre los estados de la llamada
                                @endforelse
                            </select>
                        </div>
                        </div>
                    </div>

                    <div class="col-sm-4" style="margin-left: 15px;margin-top: 15px;">
                        <div class="form-group">
                            <div class="input-group">
                            <select class="form-control selectpicker" name="clientes_select" id="clientes_select" data-live-search="true">
                                <option value="T">CLIENTES</option>
                                @foreach($clientes as $cli)
                                @if($cli->zona_id == Auth::user()->zonas->id)
                                <option value="{{$cli->id}}"> {{$cli->nombres}} {{$cli->apellidos}} {{ ($cli->asesor_venta_id == Config::get('params.global.user_asesorventa_id')) ? ' : No asignado' : (($cli->autor == 1) ? ' : Cliente' : ' : Posible cliente' )}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="card-body">

                        <div class="col-sm-1" style="margin-top: 15px;display:none">
                            <button class="btn btn-info " data-filter="search" id="btn_buscar_info"><i class="fa fa-search"></i></button>
                        </div>
                        <table id="llamadaDataTable" class="table table-striped table-bordered nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>F. de llamada</th>
                                    <th>Cliente</th>
                                    <th>Tipo Contacto</th>
                                    <th>Duración</th>
                                    <th>Observación</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

            @include('registrollamada.historial')


        </main>