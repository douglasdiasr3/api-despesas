<?php

namespace App\Http\Controllers;

use App\Models\Despesas;
use App\Models\User;
use App\Notifications\DespesaCadastrada;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;


class DespesasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Despesas::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'descricao' => 'required|max:191',
            'data' => 'required|required|date_format:"d/m/Y"|before:tomorrow',
            'valor' => 'required|numeric|gt:0',
            'user_id' => 'required|exists:App\Models\User,id',
        ]);

        $despesa =  Despesas::create($request->all());
        $user = User::find($request->user_id);
        Notification::route('mail', $user->email)
            ->notify(new DespesaCadastrada($user,$despesa));

        return response([
            $despesa
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->user_id) {
            return Despesas::where('user_id', $request->user_id)->get();
        } else {
            return Despesas::all();
        }
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
        $request->validate([
            'descricao' => 'required|max:191',
            'data' => 'required|required|date_format:"d/m/Y"|before:tomorrow',
            'valor' => 'required|numeric|gt:0',
            'user_id' => 'required|exists:App\Models\User,id',
        ]);

        $despesas = Despesas::find($id);

        if (is_null($despesas)) {
            return response([
                'message' => 'Este registro está deletado'
            ], 200);
        } else {
            $despesas->update($request->all());
        }
        return $despesas;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $retorno = Despesas::destroy($id);

        if ($retorno == 0) {
            return response([
                'message' => 'Este registro já estava deletado'
            ], 200);
        } else {
            return response([
                'message' => 'Registro deletado'
            ], 200);
        }
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Despesas::where('name', 'like', '%' . $name . '%')->get();
    }
}
