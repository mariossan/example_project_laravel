<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsercreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\SendNewPassword;
use App\Mail\Usercreated;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
    * @return
    */
    public function __construct()
    {
        $this->middleware(['auth', 'roles:Administrador']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.users.index", [
            "users" => User::with("role")->where('status', '<>', -1)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.users.create", [
            'user'  => new User(),
            'roles' => Role::whereStatus(1)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsercreateRequest $request)
    {
        $data = $request->validated();

        if ( $data["password"]  == null ) {
            return back()->withErrors(["password" => "El password es obligatorio"])->withInput();
        }

        if ( $data["role_id"] == 0 ) {
            return back()->withErrors(["role_id" => "El rol es obligatorio"])->withInput();
        }

        // se crea al usuario
        $original_pass      = $data["password"];
        $data["password"]   = bcrypt( $original_pass );

        $result = User::create($data);

        // send email to user
        $data["password"] = $original_pass;

        try {
            //code...
            Mail::to($data['email'])->queue(new Usercreated( $data ));

        } catch (\Throwable $th) {
            \Log::info($th);

        }


        if ( $result ) {
            return redirect()->route("users.index")->with("status", [
                "status"    => "success",
                "message"   => "Usuario creado correctamente"
            ]);

        } else {
            return redirect()->route("users.index")->with("status", [
                "status"    => "error",
                "message"   => "Ocurrión un problema, por favor intentelo nuevamente"
            ]);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view("admin.users.edit", [
            'user'  => $user,
            'roles' => Role::whereStatus(1)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        // si el passowrd no viene se elimina
        if ( $data["password"]  == null) {
            unset($data['password']);
        } else {
            $original_pass      = $data["password"];
            $data["password"]   = bcrypt( $original_pass );
        }

        if ( $data["role_id"] == 0 ) {
            return back()->withErrors(["role_id" => "El rol es obligatorio"])->withInput();
        }

        $responseUpdate = User::whereId( $user->id )->update($data);

        if ( $responseUpdate ) {
            return redirect()->route("users.index")->with("status", [
                "status"    => "success",
                "message"   => "Usuario actualizado correctamente"
            ]);

        } else {
            return redirect()->route("users.index")->with("status", [
                "status"    => "error",
                "message"   => "Ocurrió un error, intente nuevamente."
            ]);

        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::whereId( $user->id )->update([
            'status'    => -1,
            'email'     => $user->email."_old_".date('YmdHis')
        ]);

        return [
            "status"    => "success",
            "message"   => "Usuario eliminado correctamente"
        ];
    }

    /**
    * @return
    */
    public function changeStatus(User $user)
    {
        $status     = !$user->status;
        $message    = ( $status == 1 )? "Activado" : "Inactivado";

        User::whereId( $user->id )->update([
            'status'    => $status
        ]);

        return redirect()->route("users.index")->with("status",[
            "status"    => "success",
            "message"   => "Usuario $user->name $message"
        ]);
    }

    /**
    * @return
    */
    public function resendPassword(User $user)
    {
        $passwd                 = Str::random(4)."_".Str::random(4)."#".Str::random(4);
        $data['password']       = bcrypt($passwd);

        try {
            // update user with new password
            User::whereId( $user->id )->update( $data );

            // Envío de correo electrónico
            $data['clear_passwd']   = $passwd;
            Mail::to($user->email)->queue(new SendNewPassword( $data ));

            return back()->with('status', [
                'status'     => 'success',
                "message"   => "Contraseña enviada correctamente a $user->name"
            ]);

        } catch (\Throwable $th) {

            echo $th; die();

            return back()->with('status', [
                'status'     => 'error',
                "message"   => "Ocurrió un error, por favor intentelo mas tarde"
            ]);
        }
    }
}
