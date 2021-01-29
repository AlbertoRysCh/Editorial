@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Usarios</h4>
                <a type="button" href="{{route('usuarios.create')}}" class="btn btn-primary create">
                    <i class="fa fa-plus"></i> Crear
                </a>
            </div>
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Datos usuario</th>
                                    <th>Username</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Datos usuario</th>
                                    <th>Username</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
    <script>
    $.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
        return true;
    }
    );

    var table = $('.data-table').DataTable({
    language,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url":      "{{route('usuarios.indexTable')}}",
        "dataType": "json",
        "type":     "POST",
        "data":     function (data) {
        data._token     = "<?= csrf_token() ?>";
        },
    }, "preDrawCallback": function (settings) {
    },
    "drawCallback": function (settings) {
    },
    "columns": [
        {"data": "action", "searchable": false, "orderable": false, 'className': 'dropdown', "width": "10%"},
        {"data": "datos_usuario"},
        {"data": "username"},
        {"data": "rol_usuario"},
        {"data": "estado"},
    ],
    "columnDefs": [ {
    "targets": 0,
    "orderable": false
    }],

    });
    $.fn.dataTable.ext.errMode = () => console.log('Error en la carga de la tabla. Por favor refrescar página.');
    </script>
@endsection
