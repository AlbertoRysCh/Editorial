<div class="title" style="display: none">{{$title}}</div>
    <form action="{{route('clientes.update',$cliente)}}" method="POST" id="form_clientes_edit" autocomplete="off">
            {{method_field('patch')}}
            {{csrf_field()}}
            <input type="hidden" name="cliente_id" id="cliente_id" value="{{$cliente->id}}" readonly>
            <span class="text-center bg-info colors-container rounded text-white width-100 height-100">Código:</span>
            <p class="form-control-static" id="codigo" name="codigo">{{$cliente->codigo}}</p>

            <ul class="list-unstyled mb-0">
                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input check_class" name="tipo_persona_id" id="juridica" {{1 == $cliente->tipo_persona_id ? 'checked' : ''}} value="1">
                            <label class="custom-control-label" for="juridica">Jurídica</label>
                        </div>
                    </fieldset>
                </li>
                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input check_class" name="tipo_persona_id" id="natural" {{2 == $cliente->tipo_persona_id ? 'checked' : ''}} value="2">
                            <label class="custom-control-label" for="natural">Natural</label>
                        </div>
                    </fieldset>
                </li>
            </ul>
            <br>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">Tipo Documento</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="tipo_documento" id="tipo_documento" required>
                        <option disabled value="">== Seleccione ==</option>
                    </select>
                </div>

                <label class="col-md-2 form-control-label">Número documento</label>
                <div class="col-md-4">
                    <input type="hidden" class="num_documento_hidden" readonly value="{{$cliente->num_documento}}">
                    <input type="text" id="num_documento" name="num_documento"
                    class="form-control validar_num_documento solo_numeros" value="{{$cliente->num_documento}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">Nombres: </label>
                <div class="col-md-4">
                    <input type="text" name="nombres_rz" placeholder="Nombres" class="form-control solo_letras"
                    value="{{$cliente->nombres_rz}}">
                </div>

                <label class="col-md-2 form-control-label">Dirección: </label>
                <div class="col-md-4">
                    <input type="text" name="direccion" class="form-control" value="{{$cliente->direccion}}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 form-control-label">Correo</label>
                <div class="col-md-4">
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese el correo"
                value="{{$cliente->correo}}">
                </div>
                <label class="col-md-2 form-control-label">Teléfono</label>
                <div class="col-md-4">
                    <input type="text" id="telefono" name="telefono" class="form-control mask-telefono" value="{{$cliente->telefono}}">
                </div>
            </div>

            <div class="form-group row">
                @if($cliente->is_empleado == 0)
                <label class="col-md-2 form-control-label">Aviso</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="aviso_id" id="aviso_id" required>
                        <option disabled value="">== Seleccione ==</option>
                        @forelse($avisos as $items)
                            <option {{$items->id == $cliente->aviso_id ? 'selected' : ''}}
                            value="{{$items->id}}">{{$items->codigo}} - {{$items->nombre}}</option>
                        @empty
                            Registre los avisos
                        @endforelse
                    </select>
                </div>
                @endif

            </div>

    </form>
    <script src="{{asset('js/functions-modal.js')}}"></script>
    <script>
    $('#form_clientes_edit').validate({
        ignore: "",
        rules: {
            correo: {
                is_email: true
            },
            telefono: {
                is_phone: true
            },
            num_documento: {
                minlength: 8,
                maxlength: 15,
                required: {
                depends: function () {
                    var tipo_documento = $('#tipo_documento').val();
                        if(tipo_documento != 'OTRO'){
                            return true;
                        }
                }
            }
            },
            nombres: {
                required: true
            },
        },
        messages: {
            correo: {
               is_email: "Formato de correo inválido",
           },
           telefono: {
               is_phone: "Número de teléfono incompleto",
           },
           num_documento: {
               required: "Número es requerido",
               minlength: "Mínimo 8 números",
               maxlength: "Máximo 15 números"
           },
           nombres: {
               required: "Nombre es requerido",
           },

       },
        highlight: function (element) {
            $(element).parent().addClass('error')
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('error')
        }


    });
    </script>
