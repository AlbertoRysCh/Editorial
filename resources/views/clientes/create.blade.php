<div class="title" style="display: none">{{$title}}</div>
    <form action="{{route('clientes.store')}}" method="POST" autocomplete="off" id="form_clientes">
        {{csrf_field()}}
        <input type="hidden" name="cliente_id" id="cliente_id" value="0" readonly>
            <div class="form-group" style="display: none">
                <label>Código: </label>
                <input type="text" id="codigo" name="codigo" class="form-control" readonly>
            </div>

            <ul class="list-unstyled mb-0">
                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input check_class" name="tipo_persona_id" id="juridica" checked value="1">
                            <label class="custom-control-label" for="juridica">Jurídica</label>
                        </div>
                    </fieldset>
                </li>
                <li class="d-inline-block mr-2">
                    <fieldset>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input check_class" name="tipo_persona_id" id="natural" value="2">
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
                    <input type="hidden" class="num_documento_hidden" readonly>
                    <input type="text" id="num_documento" name="num_documento"
                     class="form-control validar_num_documento solo_numeros">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">Nombres: </label>
                <div class="col-md-4">
                    <input type="text" name="nombres_rz" placeholder="Nombres" class="form-control solo_letras">
                </div>

                <label class="col-md-2 form-control-label">Dirección: </label>
                <div class="col-md-4">
                    <input type="text" name="direccion" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 form-control-label">Correo</label>
                <div class="col-md-4">
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese el correo">
                </div>
                <label class="col-md-2 form-control-label">Teléfono</label>
                <div class="col-md-4">
                    <input type="text" id="telefono" name="telefono" class="form-control mask-telefono">
                </div>
            </div>


    </form>
    <script src="{{asset('js/functions-modal.js')}}"></script>
    <script>
    $('#form_clientes').validate({
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
