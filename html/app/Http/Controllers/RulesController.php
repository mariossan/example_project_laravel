<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Rule;
use App\Models\Talent;
use Illuminate\Http\Request;

class RulesController extends Controller
{
    /**
    * @method
    * @param
    * @return
    */
    public function index()
    {
        $reglas = Rule::whereStatus(1)->get();
        foreach ($reglas as $key => $regla) {
            $ids_tipos              = explode(",", $regla->ids_tipos);
            $tipos                  = Talent::whereIn('id', $ids_tipos)->get()->pluck('name')->toArray();
            $reglas[ $key ]->tipos  = implode("<br>", $tipos);
        }

        return view('admin.posicion-global.reglas.index', ['reglas' => $reglas]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function addRule()
    {
        return view('admin.posicion-global.reglas.create',[
            'rule'      => new Rule(),
            'tipos'     => Talent::whereStatus(1)->select('id', 'name')->orderBy('name', 'asc')->get(),
            'dealers'   => Dealer::whereStatus(1)->select('id', 'business_name')->orderBy('business_name', 'asc')->get()
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function saveRule(Request $request)
    {
        /* recepcion de informacion para poder guardarla dentro de la base de datos */
        $data =  $request->all();

        /* se elimina el token para que no estorbe */
        unset( $data["_token"] );

        $data['ids_tipos'] = implode(',', $data['ids_tipos']);

        /* se gaurda la informacion */
        $response = Rule::create( $data );

        if ( isset( $response->id ) ) {
            return redirect()->route('posicion-global.rules-index')->with('status', [
                'status'    => 'success',
                'message'   => 'Regla creada exitosamente.'
            ]);

        } else {
            return redirect()->route('posicion-global.rules-index')->with('status', [
                'status'    => 'error',
                'message'   => 'Ocurrió un error inesperado. Intente nuevamente'
            ]);
        }
    }

    /**
    * @method
    * @param
    * @return
    */
    public function editRule(Rule $rule)
    {
        $rule->ids_tipos = explode(',', $rule->ids_tipos);

        return view('admin.posicion-global.reglas.edit',[
            'rule'      => $rule,
            'tipos'     => Talent::whereStatus(1)->select('id', 'name')->orderBy('name', 'asc')->get(),
            'dealers'   => Dealer::whereStatus(1)->select('id', 'business_name')->orderBy('business_name', 'asc')->get()
        ]);

        return $rule;
    }

    /**
    * @method
    * @param
    * @return
    */
    public function updateRule(Rule $rule, Request $request)
    {

        /* recepcion de informacion para poder guardarla dentro de la base de datos */
        $data =  $request->all();

        /* se elimina el token para que no estorbe */
        unset( $data["_token"] );

        $data['ids_tipos'] = implode(',', $data['ids_tipos']);

        /* se gaurda la informacion */
        $response = Rule::whereId( $rule->id )->update( $data );

        if ( $response ) {
            return redirect()->route('posicion-global.rules-index')->with('status', [
                'status'    => 'success',
                'message'   => 'Regla actualzada exitosamente.'
            ]);

        }

        return redirect()->route('posicion-global.rules-index')->with('status', [
            'status'    => 'error',
            'message'   => 'Ocurrió un error inesperado. Intente nuevamente'
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function delRule(Rule $rule)
    {
        $response   = Rule::whereId( $rule->id )->update(['status' => 0]);

        if ( $response ) {

            return redirect()->route('posicion-global.rules-index')->with('status', [
                'status'    => 'success',
                'message'   => 'Regla dada de baja exitosamente.'
            ]);
        }

        return [
            'status'    => 'error',
            'message'   => 'Ocurrió un error inesperado. Intente nuevamente'
        ];
    }

}
