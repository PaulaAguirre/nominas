<?php

namespace App\Http\Controllers;

use App\SupervisorGuiaTigo;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class SupervisorGuiaTigoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $supervisor_id = $request->get('supervisor_id');
        $supervisores = SupervisorGuiaTigo::supervisor($supervisor_id)->get();

        return \view('tiendas.supervisores.index', ['supervisores'=>$supervisores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('tiendas.supervisores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ch' => 'required|unique:supervisor_guiatigo'
        ]);

        $supervisor = new SupervisorGuiaTigo();
        $supervisor->fill($request->all());
        $supervisor->save();

        return redirect('supervisores_tienda');
    }

    /**
     * Display the specified resource.
     *
     * @param SupervisorGuiaTigo $supervisorGuiaTigo
     * @return \Illuminate\Http\Response
     */
    public function show(SupervisorGuiaTigo $supervisorGuiaTigo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SupervisorGuiaTigo $supervisorGuiaTigo
     * @return Factory|View
     */
    public function edit($id)
    {
        $supervisor = SupervisorGuiaTigo::findOrFail($id);
        return \view('tiendas.supervisores.edit', ['supervisor'=>$supervisor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $supervisor = SupervisorGuiaTigo::findOrFail($id);
        $supervisor->fill($request->all());
        $supervisor->update();
        return redirect('supervisores_tienda');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SupervisorGuiaTigo $supervisorGuiaTigo
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupervisorGuiaTigo $supervisorGuiaTigo)
    {
        //
    }
}
