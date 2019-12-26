<?php

namespace App\Http\Controllers;

use App\Teamleader;
use App\Tienda;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeamleaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $teamleader_id = $request->get('teamleader_id');
        $tienda_id = $request->get('tienda_id');
        $teamleaders = Teamleader::tl($teamleader_id)->tienda($tienda_id)->get();
        $tiendas = Tienda::all();

        return view('tiendas.teamleaders.index', ['teamleaders'=>$teamleaders, 'tiendas'=>$tiendas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tiendas.teamleaders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'ch' => Rule::unique('teamleaders', 'ch')->where(function ($query){
               return $query->whereNotNull('ch');
           })
        ]);

        $teamleader = New Teamleader();
        $teamleader->ch = $request->get('ch');
        $teamleader->documento = $request->get('documento');
        $teamleader->nombre = $request->get('nombre');
        $teamleader->save();

        return redirect('teamleaders');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teamleader  $teamlider
     * @return \Illuminate\Http\Response
     */
    public function show(Teamleader $teamlider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teamleader  $teamlider
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $teamleader = Teamleader::findOrFail($id);
        //$tiendas_del_tl = $teamleader->tiendas->pluck('id')->toArray();
        //$tiendas = Tienda::whereNotIn('id', $tiendas_del_tl)->orderBy('tienda_nombre')->get();
        $tiendas = Tienda::all();
        return view('tiendas.teamleaders.edit', ['teamleader'=>$teamleader, 'tiendas'=>$tiendas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teamleader  $teamlider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $teamleader = Teamleader::findOrFail($id);
        $tiendas_id = $request->get('tienda_id');

        $teamleader->tiendas()->sync($tiendas_id);

        return redirect('teamleaders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teamleader  $teamlider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teamleader $teamlider)
    {
        //
    }
}
