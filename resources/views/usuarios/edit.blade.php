<div class="title" style="display: none">{{$title}}</div>
    <form action="{{route('usuarios.update',$usuario)}}" method="POST" id="form_usuarios_edit" autocomplete="off">
            {{method_field('patch')}}
            {{csrf_field()}}

            <div class="form-group row">
                <label class="col-md-2 form-control-label">Tipo Documento</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="tipo_documento" id="tipo_documento" required>
                        <option disabled value="">== Seleccione ==</option>
                        @foreach($tipoDocumentos as $items)
                        <option {{$items->nombre == $usuario->tipo_documento ? 'selected' : ''}}
                            value="{{$items->id}}">{{$items->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <label class="col-md-2 form-control-label">Número documento</label>
                <div class="col-md-4">
                    <input type="text" id="num_documento" name="num_documento"
                    class="form-control solo_numeros"
                    placeholder="Ingrese el número documento" required minlength="8"
                    maxlength="15" value="{{$usuario->num_documento}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">Nombres: </label>
                <div class="col-md-4">
                    <input type="text" name="name" placeholder="Nombres" class="form-control solo_letras"
                    value="{{$usuario->name}}">
                </div>

                <label class="col-md-2 form-control-label">Correo</label>
                <div class="col-md-4">
                <input class="form-control" id="email" name="email" placeholder="Ingrese el correo"
                value="{{$usuario->email}}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 form-control-label">Dirección</label>
                <div class="col-md-4">
                <input type="text" class="form-control" id="direccion" name="direccion" value="{{$usuario->direccion}}">
                </div>
                <label class="col-md-2 form-control-label">Teléfono</label>
                <div class="col-md-4">
                    <input type="text" id="telefono" name="telefono" class="form-control mask-telefono" value="{{$usuario->telefono}}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 form-control-label">Username: </label>
                <div class="col-md-4">
                    <input type="text" name="username" placeholder="Nombre de usuario" class="form-control"
                    value="{{$usuario->username}}" readonly>
                </div>

                <label class="col-md-2 form-control-label">Contraseña: </label>
                <div class="col-md-4">
                <input type="password" class="form-control" name="password" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 form-control-label">Rol</label>
                <div class="col-md-4">
                    <select class="form-control select2" name="rol_id" id="rol_id" required>
                        <option disabled value="">== Seleccione ==</option>
                        @forelse($roles as $items)
                            <option {{$items->id == $usuario->rol_id ? 'selected' : ''}} value="{{$items->id}}">{{$items->nombre}}</option>
                        @empty
                            Registre los roles
                        @endforelse
                    </select>
                </div>
                <label class="col-md-2 form-control-label">Estado</label>
                <div class="col-md-4">
                        <select class="form-control select2" name="estado" id="estado">
                            <option disabled value="">== Seleccione ==</option>
                            <option {{1 == $usuario->estado ? 'selected' : ''}} value="1">Activo</option>
                            <option {{0 == $usuario->estado ? 'selected' : ''}} value="0">Desactivado</option>
                        </select>
                </div>

            </div>
            <div class="form-group row distritos_select">
                <label class="col-md-2 form-control-label">Distritos</label>
                <div class="col-md-12">
                    <select class="form-control select2" name="distrito_ubigeo[]" id="distrito_ubigeo" multiple>
                        <option disabled value="">== Seleccione ==</option>
                        @forelse($distritos as $items)
                            <option {{ in_array($items->ubigeo, $distritoSelected) ? 'selected' : ''}} value="{{$items->ubigeo}}">{{$items->distrito}}</option>
                        @empty
                            Registre los roles
                        @endforelse
                    </select>
                </div>


            </div>

    </form>
    <script src="{{asset('js/functions-modal.js')}}"></script>
    <script src="{{asset('js/modules/users.js')}}"></script>
