@extends('layouts.app')
@section('content')
<div class="content-body">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Perfil configuraciones</h2>
                </div>
            </div>
        </div>
    </div>
<!-- account setting page start -->
<section id="page-account-settings">
<div class="row">
<!-- left menu section -->
<div class="col-md-3 mb-2 mb-md-0">
<ul class="nav nav-pills flex-column mt-md-0 mt-1">
    <li class="nav-item">
        <a class="nav-link d-flex py-75 active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
            <i class="feather icon-globe mr-50 font-medium-3"></i>
            Generales
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex py-75" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
            <i class="feather icon-lock mr-50 font-medium-3"></i>
            Cambiar contraseña
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link d-flex py-75" id="account-pill-notifications" data-toggle="pill" href="#account-vertical-notifications" aria-expanded="false">
            <i class="feather icon-message-circle mr-50 font-medium-3"></i>
            Notificaciones
        </a>
    </li> --}}
</ul>
</div>
<!-- right content section -->
<div class="col-md-9">
<div class="card">
    <div class="card-content">
    <div class="card-body">
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
        <form action="{{route('update.profile',$usuario)}}" method="POST" id="form_usuario_perfil" autocomplete="off" enctype="multipart/form-data">
            {{csrf_field()}}
                @if(Auth::user()->photo)
                    <img class="round" src="{{asset('/images/perfiles/'.Auth::user()->photo)}}"class="rounded mr-75" alt="profile image" height="64" width="64">
                @else
                    <img class="round" src="{{asset('/images/perfiles/user.png')}}" class="rounded mr-75" alt="profile default" height="64" width="64">
                @endif
            <div class="media-body mt-75">
                <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                    <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer" for="photo">Subir foto</label>
                    <input id="photo" type="file" name="photo" onchange="ValidateFile(this);" hidden>
                </div>
                <p class="text-muted ml-75 mt-50"><small>Permitido JPG, o PNG. Max. Tamaño de 800 kB</small></p>
            </div>
        <hr>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <div class="controls">
                            <label for="username">Usuario</label>
                        <input type="text" class="form-control" name="username" value="{{$usuario->username}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="controls">
                        <label for="num_documento">Número documento</label>
                        <input type="text" class="form-control" value="{{$usuario->tipo_documento.' - '.$usuario->num_documento}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="controls">
                            <label for="name">Nombres</label>
                        <input type="text" class="form-control solo_letras" name="name" value="{{$usuario->name}}" required>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="controls">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control" name="email" value="{{$usuario->email}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="controls">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control mask-telefono" name="telefono" value="{{$usuario->telefono}}">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="controls">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" name="direccion" value="{{$usuario->direccion}}">
                        </div>
                    </div>
                </div>
                {{-- <div class="col-12">
                    <div class="alert alert-warning alert-dismissible mb-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <p class="mb-0">
                            Your email is not confirmed. Please check your inbox.
                        </p>
                        <a href="javascript: void(0);">Resend confirmation</a>
                    </div>
                </div> --}}

                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                    <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>
    <div class="tab-pane fade " id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
        <form action="{{route('update.password')}}" method="POST" id="form_update_password" autocomplete="off">
            {{csrf_field()}}
            <div class="row">
                {{-- <div class="col-12">
                    <div class="form-group">
                        <div class="controls">
                            <label for="old_password">Contraseña actual</label>
                            <input type="password" class="form-control" name="old_password" id="old_password" required>
                        </div>
                    </div>
                </div> --}}
                <div class="col-12">
                    <div class="form-group">
                        <div class="controls">
                            <label for="password">Nueva contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="controls">
                            <label for="password_confirm">Repetir contraseña</label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                    <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>

    {{-- <div class="tab-pane fade" id="account-vertical-notifications" role="tabpanel" aria-labelledby="account-pill-notifications" aria-expanded="false">
        <div class="row">
            <h6 class="m-1">Activity</h6>
            <div class="col-12 mb-1">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input" checked id="accountSwitch1">
                    <label class="custom-control-label mr-1" for="accountSwitch1"></label>
                    <span class="switch-label w-100">Email me when someone comments
                        onmy
                        article</span>
                </div>
            </div>
            <div class="col-12 mb-1">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input" checked id="accountSwitch2">
                    <label class="custom-control-label mr-1" for="accountSwitch2"></label>
                    <span class="switch-label w-100">Email me when someone answers on
                        my
                        form</span>
                </div>
            </div>
            <div class="col-12 mb-1">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="accountSwitch3">
                    <label class="custom-control-label mr-1" for="accountSwitch3"></label>
                    <span class="switch-label w-100">Email me hen someone follows
                        me</span>
                </div>
            </div>
            <h6 class="m-1">Application</h6>
            <div class="col-12 mb-1">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input" checked id="accountSwitch4">
                    <label class="custom-control-label mr-1" for="accountSwitch4"></label>
                    <span class="switch-label w-100">News and announcements</span>
                </div>
            </div>
            <div class="col-12 mb-1">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="accountSwitch5">
                    <label class="custom-control-label mr-1" for="accountSwitch5"></label>
                    <span class="switch-label w-100">Weekly product updates</span>
                </div>
            </div>
            <div class="col-12 mb-1">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input" checked id="accountSwitch6">
                    <label class="custom-control-label mr-1" for="accountSwitch6"></label>
                    <span class="switch-label w-100">Weekly blog digest</span>
                </div>
            </div>
            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                    changes</button>
                <button type="reset" class="btn btn-outline-warning">Cancel</button>
            </div>
        </div>
    </div> --}}
            </div>
        </div>
    </div>
</div>
</div>
</div>
</section>
    <!-- account setting page end -->

</div>
@endsection
@section('custom-js')
<script>
    /*No permitir espacios*/
    jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    });
    $('#form_update_password').validate({
        rules: {
            password: {
                minlength: 8,
                maxlength: 20,
                noSpace:true
             },
             password_confirm: {
                minlength: 8,
                maxlength: 20,
                equalTo: "#password",
                noSpace:true

             },
        },
        messages: {
            password: {
            minlength: "Minimo 8 caracteres",
            maxlength: "Máximo 20 caracteres",
            equalTo: "Las contraseñas no coninciden.",
            noSpace: "No se permiten espacios",
        },
        password_confirm: {
            minlength: "Minimo 8 caracteres",
            maxlength: "Máximo 20 caracteres",
            equalTo: "Las contraseñas no coninciden.",
            noSpace: "No se permiten espacios",
        }
       },
        highlight: function (element) {
            $(element).parent().addClass('error')
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('error')
        },
    });
    $('#form_usuario_perfil').validate({
        rules: {
            email: {
                is_email: true,
                maxlength: 255,

            },
            direccion: {
                maxlength: 255,
            },
            telefono: {
                is_phone: true
            }
        },
        messages: {
            email: {
            is_email: "Formato de correo inválido",
                maxlength: "Máximo 255 caracteres",
            },
            direccion: {
                maxlength: "Máximo 255 caracteres"
            },
            telefono: {
                is_phone: "Número de teléfono incompleto",
            },
       },
        highlight: function (element) {
            $(element).parent().addClass('error')
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('error')
        },
    });
</script>
@endsection
