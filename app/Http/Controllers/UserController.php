<?php

namespace App\Http\Controllers;

//Request
use Illuminate\Http\Request;
use App\Http\Request\Users\Store;
use App\Http\Request\Users\Update;

use Illuminate\Support\Facades\View;
use App\Http\Services\ElementsHtmlService;
use App\Helpers\SelectHelper;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
// Modelos
use App\User;
use App\Models\Rol;
use Exception;
use App\Helpers\LogSystem;
use App\Models\DistritoVendedor;
// use App\Models\Ubigeo;

class UserController extends Controller
{
    const VALUE = 'value';

    const MENSAJE = 'mensajeSuccess';
    const MENSAJE_INFO = 'mensajeInfo';

    protected $selectType;

    public function __construct()
    {
        $this->selectType = new SelectHelper();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $array_obj  = [

        ];
        return View::make('usuarios.index', $array_obj);
    }
    public function indexTable(Request $request)
    {
        $columns = array(
            0 => 'users.id',
            1 => 'users.nombre',
            2 => 'users.username'
        );
        $obj        = [];
        $obj        = new User();
        $limit      = $request->length;
        $order      = $columns[$request->input('order.0.column')];
        $dir        = $request->input('order.0.dir')=='asc'?'desc':'asc';
        $obj        = $obj->join('roles','users.rol_id','=','roles.id');
        $obj        = $obj->select('users.*','roles.nombre as rol_usuario');


        $totalData  = $obj->count();


        // FILTROS POR BUSQUEDA
        if (isset($request->search['value'])) {

            $search = $request->search['value'];
            if($search == 'Activo' || $search == 'Desactivado'){
                switch ($search) {
                    case 'Activo':
                        $search_number = 1;
                        break;
                    case 'Desactivado':
                        $search_number = 0;
                        break;

                }
                $obj    = $obj->where(function ($query) use ($search,$search_number) {
                    $query->where('users.estado', 'LIKE', '%' . $search_number . '%');
                    $query->orWhere('users.nombre', 'like', "%{$search}%");
                    $query->orWhere('users.email','like', "%{$search}%");
                    $query->orWhere('users.username','like', "%{$search}%");
                    $query->orWhere('users.num_documento', 'like', "%{$search}%");
                    $query->orWhere('users.tipo_documento', 'like', "%{$search}%");
                    $query->orWhere('users.direccion', 'like', "%{$search}%");
                });
            }else{
                $obj    = $obj->where(function ($query) use ($search) {
                    $query->orWhere('users.nombre', 'like', "%{$search}%");
                    $query->orWhere('users.email','like', "%{$search}%");
                    $query->orWhere('users.username','like', "%{$search}%");
                    $query->orWhere('users.num_documento', 'like', "%{$search}%");
                    $query->orWhere('users.tipo_documento', 'like', "%{$search}%");
                    $query->orWhere('users.direccion', 'like', "%{$search}%");
                });
            }
        }

        // FILTROS DINAMICO

        $totalFiltered = $obj->count();
        $obj           = $obj->offset($request->start);
        $obj           = $obj->limit($limit); //limite
        $obj           = $obj->orderBy($order, $dir);
        $obj           = $obj->get();
        $data          = array();
        if ($obj) {
            // $i=1;
            foreach ($obj as $load) {
                /*opciones (action)*/
                $optionsElements = $dataAtribute = [];
                $dataAtribute []    = (object)['name' => 'id', self::VALUE => $load->id];

                $optionsElements [] = (object)[
                    'name'   => 'Editar',
                    'icon'   => 'feather icon-edit-2',
                    'target' => '_self',
                    'route'  => url('usuarios/'.$load->id.'/edit'),
                    'data'   => $dataAtribute,
                    'class'  => 'edit',
                ];
                $optionsElements [] = (object)[
                    'name'   => $load->estado == 1 ? 'Desactivar': 'Activar',
                    'icon'   => $load->estado == 1 ? 'feather icon-user-minus' : 'feather icon-user-check',
                    'target' => '_self',
                    'route'  => route('usuarios.act.desac',$load->id),
                    'data'   => $dataAtribute,
                    'class'  => 'activar_desactivar',
                ];


                /*datos de usuario*/
                $datos_usuario    = [];
                $datos_usuario [] = (object)['title' => 'Nombres:', 'body' => $load->name];
                $datos_usuario [] = (object)['title' => 'Tipo documento:', 'body' => $load->tipo_documento];
                $datos_usuario [] = (object)['title' => 'Número documento:', 'body' => $load->num_documento];
                $datos_usuario [] = (object)['title' => 'Correo:', 'body' => $load->email];

                switch ($load->estado) {
                    case 0:
                        $estado = '<div class="badge badge-pill badge-glow badge-danger mr-1 mb-1">Desactivado</div>';
                        break;
                    case 1:
                        $estado = '<div class="badge badge-pill badge-glow badge-success mr-1 mb-1">Activo</div>';
                        break;

                }
                $dataArray['action']             = ElementsHtmlService::optionElements($optionsElements,$load->estado == 1? null:'Inactivo');
                $dataArray['datos_usuario']      = ElementsHtmlService::informativeColumn($datos_usuario);
                $dataArray['username']           = $load->username;
                $dataArray['rol_usuario']        = $load->rol_usuario;
                $dataArray['estado']             = $estado;


                $data[]                          = $dataArray;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );
        return json_encode($json_data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Creear usuario';
        $tipoDocumentos = $this->selectType->listTypeDoc();
        $roles = Rol::whereEstado(1)->get();
        // $distritos= Ubigeo::where('ubigeos.provincia', '<>', '')
        // ->where('ubigeos.distrito', '<>', '')
        // ->where('ubigeos.departamento','Lima')
        // ->where('ubigeos.provincia','Lima')->orWhere('ubigeos.provincia', 'like', "%Prov. Const. del Callao%")->orderBy('ubigeos.id','Desc')
        // ->groupBy('ubigeos.ubigeo')
        // ->get();
        $array_obj  = [
            'title'          => $title,
            'tipoDocumentos' => $tipoDocumentos,
            'roles'          => $roles,
            // 'distritos'          => $distritos,
        ];
        return View::make('usuarios.create', $array_obj);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $attributes = $request->all();
        $password = Hash::make($request->password);
        $data_merge = array_merge($attributes,['password' => $password]);
        $data = User::create($data_merge);

        if(!is_null($request->distrito_ubigeo)):
            $data->distritos()->sync($request->distrito_ubigeo);
        endif;

            $arr_msg = array(
            'message' => 'Usuario registrado correctamente',
            'status' => true);
        LogSystem::addLog($arr_msg['message'],1);
        return Response()->json($arr_msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Editar usuario';
        $usuario = User::findOrfail($id);
        $tipoDocumentos = $this->selectType->listTypeDoc();
        $roles = Rol::whereEstado(1)->get();

        $distritoSelected = [];

        if($usuario->rol_id == 4):
            $distritosAsignados = DistritoVendedor::where('user_id',$id)->get();
            foreach ($distritosAsignados as $row) :
                $distritoSelected[$row->distrito_ubigeo] = $row->distrito_ubigeo;
            endforeach;
        endif;

        $distritos= Ubigeo::where('ubigeos.provincia', '<>', '')
        ->where('ubigeos.distrito', '<>', '')
        ->where('ubigeos.departamento','Lima')
        ->where('ubigeos.provincia','Lima')->orWhere('ubigeos.provincia', 'like', "%Prov. Const. del Callao%")->orderBy('ubigeos.id','Desc')
        ->groupBy('ubigeos.ubigeo')
        ->get();

        $array_obj  = [
            'title'          => $title,
            'tipoDocumentos' => $tipoDocumentos,
            'usuario'        => $usuario,
            'roles'          => $roles,
            'distritos'          => $distritos,
            'distritoSelected'          => $distritoSelected,
        ];
        return View::make('usuarios.edit', $array_obj);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $data = User::findOrfail($id);
        $attributes = $request->except('password');
        $password_update = $request->password == null ? $data->password : Hash::make($request->password);
        $data_merge = array_merge($attributes,['password' => $password_update]);

        $data->distritos()->sync($request->distrito_ubigeo);
        $data->update($data_merge);
        $arr_msg = array(
            'message' => 'Usuario actualizado correctamente',
            'status' => true);
        LogSystem::addLog($arr_msg['message'],1);
        return Response()->json($arr_msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function activarDesactivar($id)
    {

        try{
            $usuario = User::findOrfail($id);
            $estado = $usuario->estado;
            $estado == 1 ?  $usuario->estado = 0 :  $usuario->estado = 1;

            $usuario->save();
            $e = $usuario->estado == 0 ? ' desactivado ' : ' activado ';
            $message ='Usuario'.$e.'correctamente.';
            $response = ['status' => true, 'data' => '','message' =>  $message ];
            LogSystem::addLog($message,1);
            return Response()->json($response);

        } catch (Exception $e) {
            LogSystem::addLog($e->getMessage(),0);
            $response = ['status'  => false,'data' => $e->getMessage(),'message'=>'Ocurrio un error por favor intente de nuevo o contacte con soporte.'];
            return Response()->json($response);
        }

    }
    public function searchUserNumDocumento($num_documento)
    {
        $search_num_doc = User::whereNum_documento($num_documento)->first();
        if($search_num_doc)
        {
            $arr_msg = array('message' => 'Número de documento ya se encuentra registrado',
            'status' => true);
        }else{
            $arr_msg = array('message' => 'Disponible',
            'status' => false);
        }

        return Response()->json($arr_msg);

    }

    public function searchUserName($username)
    {
        $search_username =User::whereUsername($username)->first();
        if($search_username)
        {
            $arr_msg = array('message' => 'Nombre de usuario no esta disponible',
            'status' => true);
        }else{
            $arr_msg = array('message' => 'Disponible',
            'status' => false);
        }

        return Response()->json($arr_msg);

    }
    public function searchUserEmail($useremail)
    {
        $search_useremail =User::whereEmail($useremail)->first();
        if($search_useremail)
        {
            $arr_msg = array('message' => 'El correo ya se encuentra registrado',
            'status' => true);
        }else{
            $arr_msg = array('message' => 'Disponible',
            'status' => false);
        }

        return Response()->json($arr_msg);

    }
    public function editProfile($id)
    {
        $id =Crypt::decrypt($id);
        $usuario = User::findOrfail($id);
        $array_obj  = [
            'usuario' => $usuario
        ];
        return View::make('usuarios.edit-profile', $array_obj);
    }
    public function updateProfile(Request $request,$id)
    {
        $data = User::findOrfail($id);
        $attributes = $request->all();

        $photo = ImageService::handleUploadedImage($request->file('photo'),$data,0);

        $data_merge = array_merge($attributes,['photo'=>$photo]);

        $data->update($data_merge);

        $mensaje_success = "Perfil actualizado correctamente.";
        LogSystem::addLog($mensaje_success,1);
        return back()->withInput()->with(self::MENSAJE, $mensaje_success);
    }

    public function updatePassword(Request $request) {
        $usuario_id = Auth::id();
        $password = Hash::make($request->password);
        $data = User::find($usuario_id);
        $data->update(['password'=>$password]);
        $mensaje_success = "Contraseña actualizada correctamente.";
        LogSystem::addLog($mensaje_success,1);
        return back()->withInput()->with(self::MENSAJE, $mensaje_success);
    }
}
