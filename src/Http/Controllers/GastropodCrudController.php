<?php

namespace RadFic\Gastropod\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use RadFic\Gastropod\Gastropod;

class GastropodCrudController extends Controller
{
    public $model;
    public $gastropod;
    public $relationsMap;

    public function __construct()
    {
        $this->gastropod = new Gastropod(
            $this->model,
            $this->relationsMap
        );
    }

    /**
     * Display a listing of the records in the table.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->gastropod->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->gastropod->create();
    }

    /**
     * Store a newly created item in the database.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->gastropod->store($request);
    }

    /**
     * Display the specified item.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        return $this->gastropod->show($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Database\Eloquent\Model
     * @return \Illuminate\Http\Response
     */
    public function edit($item)
    {
        return $this->gastropod->edit($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @param  \Illuminate\Database\Eloquent\Model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item)
    {
        return $this->gastropod->update($request, $item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        return $this->gastropod->destroy($item);
    }
}
