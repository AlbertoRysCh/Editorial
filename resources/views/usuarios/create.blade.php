<div class="title" style="display: none">{{$title}}</div>
    <form action="{{route('usuarios.store')}}" method="POST" id="form_usuarios_create" autocomplete="off">
            {{csrf_field()}}
            <div class="form-group row">
                <label class="col-md-2 form-control-label">Tipo Documento</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="tipo_documento" id="tipo_documento" required>
                        <option disabled value="">== Seleccione ==</option>
                        @foreach($tipoDocumentos as $items)
                        <option value="{{$items->id}}">{{$items->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <label class="col-md-2 form-control-label">Número documento</label>
                <div class="col-md-4">
                    <input type="text" id="num_documento" name="num_documento"
                    class="form-control solo_numeros"
                    placeholder="Ingrese el número documento" minlength="8"
                    maxlength="15" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">Nombres: </label>
                <div class="col-md-4">
                    <input type="text" name="name" placeholder="Nombres" class="form-control solo_letras"
                    value="">
                </div>

                <label class="col-md-2 form-control-label">Correo</label>
                <div class="col-md-4">
                <input class="form-control" id="email" name="email" placeholder="Ingrese el correo"
                value="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 form-control-label">Dirección</label>
                <div class="col-md-4">
                <input type="text" class="form-control" id="direccion" name="direccion" value="">
                </div>
                <label class="col-md-2 form-control-label">Teléfono</label>
                <div class="col-md-4">
                    <input type="text" id="telefono" name="telefono" class="form-control mask-telefono" value="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 form-control-label">Username: </label>
                <div class="col-md-4">
                    <input type="text" name="username" placeholder="Nombre de usuario" class="form-control"
                    value="">
                </div>

                <label class="col-md-2 form-control-label">Contraseña: </label>
                <div class="col-md-4">
                <input type="text" class="form-control" name="password" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">Rol</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="rol_id" id="rol_id" required>
                        <option disabled value="">== Seleccione ==</option>
                        @forelse($roles as $items)
                            <option value="{{$items->id}}">{{$items->nombre}}</option>
                        @empty
                            Registre los roles
                        @endforelse
                    </select>
                </div>
                <label class="col-md-2 form-control-label">Estado</label>
                <div class="col-md-4">
                        <select class="form-control select2" name="estado" id="estado">
                            <option disabled value="">== Seleccione ==</option>
                            <option value="1">Activo</option>
                            <option value="0">Desactivado</option>
                        </select>
                </div>

            </div>

    </form>
    <script src="{{asset('js/functions-modal.js')}}"></script>
    <script src="{{asset('js/modules/users.js')}}"></script>
