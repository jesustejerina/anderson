<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use App\Models\User;
use App\Models\cliente;
use App\Models\pago;

use App\Http\Resources\UserResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(){
        return response()->json([
            'status'=>'OK',
            'message'=>'Usuario Registrado Correctamente.',
        ])->setStatusCode(200,'Usuario Registrado Correctamente');
    }

    public function registrar(RegisterRequest $r){
        if($r->nuevo=="SI"){
            if($r->hasFile('avatar')){
                $user_image=$r->file('avatar');
                $user_image_name=str_replace('@','-',str_replace('.','-',$r->email)).'.'.$user_image->extension(); //$user_image->getClientOriginalName();
                try {
                    $avatar=$user_image->storeAs('imagenes',$user_image_name,'public');
                } catch (\Exception $e) {
                    return response()->json([
                        'status'=>'ERROR',
                        'message'=>'No se pudo guardar imagen del usuario.',
                        'error'=>$e->getMessage()
                    ])->setStatusCode(401,'Error al guardar imagen');
                }
            }else{
                $avatar=null;
            }
        
            try {
                $user=User::create([
                    'name'=>$r->name,
                    'email'=>$r->email,
                    'password'=>Hash::make($r->password),
                    'activo'=>($r->activo=="true")?1:0,
                    'avatar'=>$avatar
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status'=>'ERROR',
                    'message'=>'No se pudo crear el Usuario.',
                    'error'=>$e->getMessage()
                ])->setStatusCode(401,'Error al crear usuario');
            }

                
            try {
                //Agregar el rol al usuario.
                if(!is_null($user)){
                    $user->assignRole($r->role);
                }else{
                    throw new Exception("Usuario nulo al crearlo", 1);
                }
                
            } catch (\Exception $e) {
                return response()->json([
                    'status'=>'ERROR',
                    'message'=>'No se pudo asignar el Rol al Usuario.',
                    'error'=>$e->getMessage()
                ])->setStatusCode(401,'Error al asignar rol al usuario');
            }

            try {
                //$elusuario=$this->getUserInfo($user);
                //ejm: return BookResource::collection(Book::all());
                //ejm: return BookResource::collection(Book::with(['book_status','authors'])->get());
                //ejm: 'authors'=>AuthorResource::collection($this->whenLoaded('authors'))
                //ejm: 'book_status'=>new BookStatusResource($this->book_status)

                $elusuario=new UserResource($user);
                
            } catch (\Exception $e) {
                return response()->json([
                    'status'=>'ERROR',
                    'message'=>'No se pudo obtener UserResource(user)',
                    'error'=>$e->getMessage()
                ])->setStatusCode(401,'No se pudo obtener UserResource(user)');
            }
            
            return response()->json([
                'status'=>'OK',
                'message'=>'Usuario Registrado Correctamente.',
                'user'=>$elusuario,
            ])->setStatusCode(200,'Usuario Registrado Correctamente');
            

        }else{ //Modificar Usuario
            $hay_foto=$r->hasFile('avatar');
            if($hay_foto){
                $user_image=$r->file('avatar');
                $user_image_name=str_replace('@','-',str_replace('.','-',$r->email)).'.'.$user_image->extension(); //$user_image->getClientOriginalName();
                try {
                    $avatar=$user_image->storeAs('imagenes',$user_image_name,'public');
                } catch (\Exception $e) {
                    return response()->json([
                        'status'=>'ERROR',
                        'message'=>'No se pudo guardar imagen del usuario.',
                        'error'=>$e->getMessage()
                    ])->setStatusCode(401,'Error al guardar imagen');
                }
            }
        /* Corregir:SOLUCIONADO!!!
        El usuario PEPE tiene el correo algo@gmail.com. Al modificar OTRO USUARIO, le pongo el email algo@gmail.com, se repite el correo pues 
        es el mismo que PEPE, en el front no aparece adecuadamente el error porque el showAlert es muy corto.
        El caso:
        No se pudo modificar el Usuario.>SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'jamaico5@gmail.com' for key 'users_email_unique' 
        (Connection: mysql, SQL: update `users` set `name` = jamaica fresa 5, `email` = jamaico5@gmail.com, `activo` = 1, `users`.`updated_at` = 2023-08-05 18:02:46 where `id` = 28)
        Modificar adecuadamente el RegisterRequest para resolver este caso.
        */

        
        /* OTRO ERROR: Modifiqué la foto del usuario y no actualizó el listado

        */
            try {
                if($hay_foto){
                    User::where('id',$r->id)
                    ->update([
                        'name'=>$r->name,
                        'email'=>$r->email,
                        'activo'=>($r->activo=="true")?1:0,
                        'avatar'=>$avatar
                    ]);
                }else{
                    User::where('id',$r->id)
                    ->update([
                        'name'=>$r->name,
                        'email'=>$r->email,
                        'activo'=>($r->activo=="true")?1:0,
                    ]);
                }

                $user=User::find($r->id);
                
                try {
                    //Quitar el rol actual
                    $rol_actual=$user->roles->first();
                    $user->removeRole($rol_actual);
                    //Agregar el rol al usuario.
                    $user->assignRole($r->role);
                } catch (\Exception $e) {
                    return response()->json([
                        'status'=>'ERROR',
                        'message'=>'No se pudo asignar el Rol al Usuario.',
                        'error'=>$e->getMessage()
                    ])->setStatusCode(401,'Error al asignar al usuario');
                }
    
                try {
                    $elusuario=new UserResource($user);
                } catch (\Exception $e) {
                    return response()->json([
                        'status'=>'ERROR',
                        'message'=>'No se pudo obtener Información del Usuario. (getUserInfo)',
                        'error'=>$e->getMessage()
                    ])->setStatusCode(401,'No se pudo obtener Información del Usuario. (getUserInfo)');
                }
                
                return response()->json([
                    'status'=>'OK',
                    'message'=>'Usuario Modificado Correctamente.',
                    'user'=>$elusuario,
                ])->setStatusCode(200,'Usuario Modificado Correctamente');
            } catch (\Exception $e) {
                return response()->json([
                    'status'=>'ERROR',
                    'message'=>'No se pudo modificar el Usuario.',
                    'error'=>$e->getMessage()
                ])->setStatusCode(401,'Error al modificar usuario');
            }
        }
    }

    private function getUserInfo($user){
        $userInfo=['name'=>$user->name,
                    'email'=>$user->email,
                    'activo'=>$user->activo,
                    'roles'=>$user->getRoleNames(),
                    'permissions'=>$user->getAllPermissions()->pluck('name')
                ];
        return $userInfo;
    }

    public function login(LoginRequest $r){
        if(!Auth::attempt($r->only('email','password'))){
            return response()->json([
                'status'=>'ERROR',
                'message'=>'Credenciales Inválidas'
            ])->setStatusCode(401,'Credenciales Inválidas');
        }else{
            $user=User::where('users.email',$r['email'])->first();
            if(!is_null($user)){
                if($user->activo==1) {
                    $elusuario=new UserResource($user);
                    return response()->json([
                        'status'=>'OK',
                        'user'=>$elusuario,
                        'access_token'=>$user->createtoken('auth_token')->plainTextToken,
                        'type_token'=>'Bearer'
                    ])->setStatusCode(200,'Usuario Autenticado');
                }else{
                    Auth::user()->tokens()->delete(); 
                    return response()->json([
                        'status'=>'ERROR',
                        'message'=>'Usuario Deshabilitado.'
                    ])->setStatusCode(401,'Usuario Deshabilitado');
                }
            }
        }
    }

    public function cambiarClave(CambiarClaveRequest $c){
        //password_actual, password, password_confirmation
        try {
            $user=User::find($c->id);
            $user->update(['password'=>Hash::make($c->password)]);
            $rpta=response()->json([
                'status'=>'OK',
                'message'=>'Clave cambiada correctamente.',
            ])->setStatusCode(200,'Clave cambiada correctamente.');
        } catch (\Exception $e) {
            $rpta=response()->json([
                'status'=>'ERROR',
                'message'=>'Error al cambiar clave',
                'error'=>$e->getMessage()
            ])->setStatusCode(401,'No se pudo cambiar clave');
        }
        
        return $rpta;

    }

    //Aquí debería recibirse en el request, el id del usuario que desea cerrar sesión.
    //Creo q con esto sacaría a todos los usuarios cuando uno solo quiera cerrar sesión?
    public function logout(Request $r){
        Auth::user()->tokens()->delete();
        return response()->json([
            'status'=>'OK',
            'message'=>'Logout'
        ])->setStatusCode(200,'Logout');
    }

    public function getUsers(){
        $users=User::all();
        $usuarios=UserResource::collection($users);
        return response()->json([
            'status'=>'OK',
            'message'=>'Listado de Usuarios',
            'usuarios'=>$usuarios
        ])->setStatusCode(200,'Listado de Usuarios');
    }

    public function dameAsesores(){
        $asesors=User::role('Asesor')->get();
        $supervisores=User::role('Supervisor')->get();
        $users=$asesors->merge($supervisores);
        $asesores=AsesorResource::collection($users);
        return response()->json([
            'status'=>'OK',
            'message'=>'Listado de Asesores',
            'asesores'=>$asesores
        ])->setStatusCode(200,'Listado de Asesores');
    }

    public function autenticado(){
        if(Auth::check()){
            return response()->json([
                'status'=>'OK',
                'autenticado'=>true,
                'message'=>'Usuario Autenticado'
            ])->setStatusCode(201,'Usuario Autenticado');
        }else{
            return response()->json([
                'status'=>'OK',
                'autenticado'=>false,
                'message'=>'Por la xuxa... el Auth:check() NO FUNCIONA'
            ])->setStatusCode(201,'...ERDA');
        }
    }

    public function activeUser($idUser){
        try {
            $user=User::find($idUser);
            if($user->activo==1){
                $user->activo=0;
                $mensaje="Usuario Desactivado";
            }else{
                $user->activo=1;
                $mensaje="Usuario Activado";
            }
            $user->save();
            return response()->json([
                'status'=>'OK',
                'message'=>$mensaje
            ])->setStatusCode(201,$mensaje);
        } catch (\Exception $e) {
            return response()->json([
                'status'=>'ERROR',
                'message'=>'Error al activar/desactivar usuario',
                'error'=>$e->getMessage()
            ])->setStatusCode(401,'Error al activar/desactivar usuario');
        }
    }

    public function borrarUsuario($idUser){
        $tablas=[];
        try {
            //Verificar en todas las tablas del sistema para ver si tiene operaciones, de ser así NO SE PUEDE BORRAR el usuario.
            $cp=Ciclo_de_pago::where('id_user',$idUser)->get();
            if($cp->count()>0) array_push($tablas,"Ciclos de Pago");
            $ca=Cliente_Adjunto::where('id_user',$idUser)->get();
            if($ca->count()>0) array_push($tablas,"Adjuntos del Cliente");
            $c=Cliente::where('id_user',$idUser)->get();
            if($c->count()>0) array_push($tablas,"Clientes");
            $cr=Cronograma_cabecera::where('id_user',$idUser)->get();
            if($cr->count()>0) array_push($tablas,"Cronogramas");
            $p=pagos_cabecera::where('id_user',$idUser)->get();
            if($p->count()>0) array_push($tablas,"Pagos");
            $sca=Solicitud_de_credito_adjunto::where('id_user',$idUser)->get();
            if($sca->count()>0) array_push($tablas,"Adjuntos de la Solicitud de Crédito");
            $scr=Solicitud_de_credito_referencia::where('id_user',$idUser)->get();
            if($scr->count()>0) array_push($tablas,"Referencias de la Solicitud de Crédito");
            $sc=Solicitud_de_credito::where('id_user',$idUser)->get();
            if($sc->count()>0) array_push($tablas,"Solicitudes de Crédito");

            if(count($tablas)>0){
                $mensaje="El usuario no puede borrarse porque tiene operaciones en: ";
                for($i=0;$i<count($tablas);$i++){
                    $mensaje.=$tablas[$i].", ";
                }
                return response()->json([
                    'status'=>'CUIDADO',
                    'message'=>$mensaje
                ])->setStatusCode(201,"Usuario no puede borrarse");
            }else{
                $user=User::find($idUser);
                $rol_actual=$user->roles->first();
                $user->removeRole($rol_actual);
                $user->delete();
                $mensaje="Usuario borrado correctamente.";
                return response()->json([
                    'status'=>'OK',
                    'message'=>$mensaje
                ])->setStatusCode(201,$mensaje);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'=>'ERROR',
                'message'=>'Error al activar/desactivar usuario',
                'error'=>$e->getMessage()
            ])->setStatusCode(401,'Error al activar/desactivar usuario');
        }
    }
}
