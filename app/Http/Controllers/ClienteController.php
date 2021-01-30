<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\AsesorVenta;
use App\Aviso;
use App\Zona;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SelectHelper;
class ClienteController extends Controller
{
    const MENSAJE = 'mensajeSuccess';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
            $data = $request->all();

            $obj=DB::table('clientes')
            ->join('grados','clientes.idgrado','=','grados.id')
            ->join('avisos','clientes.aviso_id','=','avisos.id')
            ->join('asesorventas','clientes.asesor_venta_id','=','asesorventas.id')
            ->join('zonas','clientes.zona_id','=','zonas.id')
            ->select('clientes.id','clientes.tipo_documento','clientes.num_documento',
            'clientes.nombres','clientes.apellidos','clientes.correocontacto',
            'clientes.telefono','clientes.correogmail','clientes.contrasena','clientes.resumen','clientes.universidad','clientes.orcid',
            'grados.nombre as nombregrado', 'clientes.condicion', 'clientes.idgrado','clientes.especialidad',
            'clientes.autor','avisos.nombre as nombre_aviso','clientes.asesor_venta_id','clientes.aviso_id',
            'asesorventas.nombres as nombre_asesor_venta','clientes.autor','clientes.codigo','zonas.descripcion as nombre_zona',
            'clientes.zona_id')
            ->orderBy('clientes.id','desc');
            // FILTROS
            $sql=trim($request->get('buscarTexto'));
            if ($sql == 'Activo' || $sql == 'Desactivado') {
                switch ($sql) {
                    case 'Activo':
                        $search_number = 1;
                        break;
                    case 'Desactivado':
                        $search_number = 0;
                        break;
                }
                    
                $obj    = $obj->where(function ($query) use ($search_number) {
                    $query->where('clientes.condicion', 'LIKE', '%' . $search_number . '%');
                });
            }else{
                $obj = $obj->where(function ($query) use ($sql) {
                    $query->where('clientes.nombres', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.apellidos', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.num_documento', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.tipo_documento', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.codigo', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('asesorventas.nombres', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('avisos.nombre', 'LIKE', '%'.$sql.'%');
                    $query->orwhere('clientes.condicion', 'LIKE', '%'.$sql.'%');
                });
            }


            //COUNT   
            $count = $obj->get();
            $count->count();
            
            //PAGINATE
            $clientes= $obj->paginate(10);

             /*listar los Grados en ventana modal*/
            $grados=DB::table('grados')->where('condicion','=','1')->get(); 
            /*listar Asesores de Ventas*/
            $asesorVentas=AsesorVenta::select('id','nombres','num_documento')->whereCondicion(1)->get();
            $type = new SelectHelper();
            $tipoDocumentos = $type->listTypeDoc();
            $avisos= Aviso::whereEstado(1)->get();
            $zonaVenta = Zona::whereEstado(1)->get();
            return view('cliente.index',["clientes"=>$clientes,"count"=>$count,"data"=>$data,"grados"=>$grados,'avisos'=>$avisos,"asesorVentas"=>$asesorVentas,"tipoDocumentos" => $tipoDocumentos,"buscarTexto"=>$sql,"zonaVenta"=>$zonaVenta]);
        
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asesor = Auth::user()->asesorventa == null ? null : Auth::user()->asesorventa->id;

        $cliente= new Cliente();
        $cliente->tipo_documento = $request->tipo_documento;
        $cliente->num_documento = $request->num_documento;
        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->correocontacto = $request->correocontacto;
        $cliente->telefono = $request->telefono;
        $cliente->correogmail = $request->correogmail;
        $cliente->contrasena = $request->contrasena;
        $cliente->universidad = $request->universidad;
        $cliente->orcid = $request->orcid;
        $cliente->idgrado = $request->id_grado;
        $cliente->especialidad = $request->especialidad;
        $cliente->autor = 0;
        $cliente->aviso_id = $request->aviso_id;
        if(isset($request->location)){
            $cliente->asesor_venta_id = $request->asesor_venta_id;
            $cliente->zona_id = $request->zona_id;
        }else{
            $cliente->asesor_venta_id = $asesor;
            $cliente->zona_id = Auth::user()->zonas->id;
        }
        // Se crea automaticamente el correlativo
        $consulta = Cliente::count() + 1;
        $codigo = str_pad($consulta, 7, '0', STR_PAD_LEFT);
        $cliente->codigo =  $codigo;
        $cliente->condicion = '1';

        //inicio registrar archivos

        if($request->hasFile('resumen')){

            //Get filename with the extension
            $filenamewithExt = $request->file('resumen')->getClientOriginalName();
            
            //Get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
            
            //Get just ext
            $extension = $request->file('resumen')->guessClientExtension();
            
            //FileName to store
            $fileNameToStore = time().'.'.$extension;
            
            //Upload Image
            $path = $request->file('resumen')->storeAs('public/documento/autor',$fileNameToStore);

        
       } else{

        $fileNameToStore="noimagen.jpg";
    }
    $cliente->resumen=$fileNameToStore; 

            //fin registrar imagen
            $cliente->save();
            return Redirect::to( $asesor == null ? 'cliente' : 'asesorventa_lista');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente= Cliente::findOrFail($request->cliente_id);
        $cliente->tipo_documento = $request->tipo_documento;
        $cliente->num_documento = $request->num_documento;
        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->correocontacto = $request->correocontacto;
        $cliente->telefono = $request->telefono;
        $cliente->correogmail = $request->correogmail;
        $cliente->contrasena = $request->contrasena;
        $cliente->universidad = $request->universidad;
        $cliente->orcid = $request->orcid;
        $cliente->idgrado = $request->id_grado;
        $cliente->especialidad = $request->especialidad;
        $cliente->aviso_id = $request->aviso_id;
        $cliente->asesor_venta_id = $request->asesor_venta_id;
        if (isset($request->location)) {
            $cliente->zona_id = $request->zona_id;
        }else{
            $cliente->zona_id = Auth::user()->zonas->id;
        }
        if($request->hasFile('resumen')){

            /*si la imagen que subes es distinta a la que está por defecto 
            entonces eliminaría la imagen anterior, eso es para evitar 
            acumular imagenes en el servidor*/ 
        if($cliente->resumen != 'noimagen.jpg'){ 
            Storage::delete('public/documento/autor'.$cliente->resumen);
        }

        
            //Get filename with the extension
        $filenamewithExt = $request->file('resumen')->getClientOriginalName();
        
        //Get just filename
        $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
        
        //Get just ext
        $extension = $request->file('resumen')->guessClientExtension();
        
        //FileName to store
        $fileNameToStore = time().'.'.$extension;
        
        //Upload Image
        $path = $request->file('resumen')->storeAs('public/documento/autor',$fileNameToStore);
        
        
        
    } else {
        
        $fileNameToStore = $cliente->resumen; 
    }

       $cliente->resumen=$fileNameToStore;

       $cliente->save();
       $asesor = Auth::user()->asesorventa;
       return Redirect::to( $asesor == null ? 'cliente' : 'asesorventa_lista');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente= Cliente::findOrFail($request->cliente_id);
        if($cliente->condicion=="1"){
               $cliente->condicion= '0';
               $cliente->save();
               return Redirect::to("cliente");
          }else{
               $cliente->condicion= '1';
               $cliente->save();
               return Redirect::to("cliente");

           }
    }
    public function verificarEstadoCliente($id)
    {
        $cliente= Cliente::whereId($id)->where('autor',0)->first();
        $respuestaAutor = is_null($cliente) ? null : $cliente->autor;
        $result['status'] =  $respuestaAutor === null ? false : true;
        return json_encode($result);
    }
    // public function downloadDefault($file)
    // {
    //     $pathtoFile = public_path().'/img/'.$file;
    //     return response()->download($pathtoFile);
    // }
    
}
