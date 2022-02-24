<?php

namespace RadFic\Gastropod;

use RadFic\Gastropod\GastropodAuth\GastropodAuth;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * Gastropod
 *
 * @author  Ivan Preziosi <ivan.preziosi@gmail.com>
 *
 */
class Gastropod
{
    protected $model;//eloquent model classname
    protected $tableName;//table name
    protected $relations;//eloquent relations of the model
    protected $relationsMap = [];//relations map for the views

    /**
     * Constructor
     * @param string $modelClass a model instance
     * @param array $relationsMap the relations map defined in the Controller
     */
    public function __construct($modelClass, $relationsMap)
    {
        $this->model = $modelClass;
        $item = new $this->model();//an empty eloquent instance
        $this->relations = $item->getRelations();
        $this->relationsMap = $relationsMap;
        $this->tableName = $item->getTable();
        Paginator::useBootstrap();
    }

    /**
     * Just a simple function to format show data.
     *
     * @param string $showData The string data in html format to show in the frontend.
     */
    public function formatShowData($showData)
    {
        $showData = \str_replace("[", "[<strong>", $showData);
        $showData = \str_replace("]", "</strong>]", $showData);
        return $showData;
    }

    /**
     * Display a listing of the records in the table.
     *
     * @param \Illuminate\Http\Request $request The request object have to be passed by the controller.
     * @return \Illuminate\Http\Response
     */
    public function index(\Illuminate\Http\Request $request)
    {
        if (!GastropodAuth::check()) {
            return redirect('gastropod/login');
        }

        $searchkey = $request->input('search-key', session('gastropod-index-search-key'));
        $searchField = $request->input('search-field', session('gastropod-index-search-field'));
        $itemsPerPage = $request->input('ipp');
        if (!is_numeric($itemsPerPage)) {//|| $itemsPerPage<10 || $itemsPerPage>100
            $itemsPerPage = session('gastropod-index-ipp', 10);
        } else {
            session(['gastropod-index-ipp' => $itemsPerPage]);
        }

        $query = $this->model::query();

        if ((isset($searchkey) && $searchkey != "") && (isset($searchField) && $searchField != "")) {
            $request->session()->put('gastropod-index-search-key', $searchkey);
            $request->session()->put('gastropod-index-search-field', $searchField);
            $query->orWhere($searchField, 'LIKE', '%' . $searchkey . '%');
        } else {
            $request->session()->forget('gastropod-index-search-key');
            $request->session()->forget('gastropod-index-search-field');
        }
        $items = $query->paginate($itemsPerPage);

        //$items = $this->class::orderBy('id', 'desc')->paginate(20);
        foreach ($items as $item) {
            $this->exploreRelationsForIndex($item);
        }

        $data = [
            'name'=> $this->tableName,
            'items' => $items
        ];
        return view('gastropod.index', $data);
    }

    /**
     * Explore the relations map to create entries for the index page
     *
     * @param $item a Eloquent Model instance
     */
    public function exploreRelationsForIndex($item)
    {
        foreach ($this->relationsMap as $relationData) {
            $relationData->type->index($item);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!GastropodAuth::check()) {
            return redirect('gastropod/login');
        }

        $item = new $this->model();
        $columnNames = Schema::getColumnListing($item->getTable());

        $widgets = [];
        foreach ($columnNames as $columnName) {
            foreach ($this->relationsMap as $relationData) {
                $newWidget = $relationData->type->create($columnName);
                if ($newWidget!=null) {
                    $widgets[] = $newWidget;
                }
            }
        }
        
        $data = [
            'name'=> $this->tableName,
            'columnNames' => $columnNames,
            'widgets' => $widgets
        ];
        return view('gastropod.create', $data);
    }


    /**
     * Store a newly created item in the database.
     *
     * @param  \Illuminate\Http\Request $request The request object have to be passed by the controller.
     * @return \Illuminate\Http\Response
     */
    public function store(\Illuminate\Http\Request $request)
    {
        if (!GastropodAuth::check()) {
            return redirect('gastropod/login');
        }

        $this->model::create($request->all());
        return redirect()->route($this->tableName.'.index')
                        ->with('success', 'Item created successfully.');
    }


    /**
     * Display the specified item.
     *
     * @param  \App\Models\Model  $item An Eloquent model instance to be displayed.
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        if (!GastropodAuth::check()) {
            return redirect('gastropod/login');
        }

        $itemObj = $this->model::find($item)->setHidden([]);
        foreach ($this->relationsMap as $relationData) {
            $itemObj->$relationData->name;
        }
        $data = [
            'name'=> $this->tableName,
            'itemData' => $this->formatShowData(print_r($itemObj->toArray(), true))
        ];
        return view('gastropod.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Database\Eloquent\Model $item The item to create the form for.
     * @return \Illuminate\Http\Response
     */
    public function edit($item)
    {
        if (!GastropodAuth::check()) {
            return redirect('gastropod/login');
        }

        $itemObj = $this->model::find($item)->setHidden([]);
        $columnNames = Schema::getColumnListing($itemObj->getTable());

        $widgets = [];
        foreach ($columnNames as $columnName) {
            foreach ($this->relationsMap as $relationData) {
                $newWidget = $relationData->type->edit($columnName,$itemObj);
                if ($newWidget!=null) {
                    $widgets[] = $newWidget;
                }
            }
        }
        
        $data = [
            'name'=> $this->tableName,
            'item' => $itemObj->toArray(),
            'widgets' => $widgets
        ];
        return view('gastropod.edit', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Database\Eloquent\Model $item
     * @return \Illuminate\Http\Response
     */
    public function update(\Illuminate\Http\Request $request, $item)
    {
        if (!GastropodAuth::check()) {
            return redirect('gastropod/login');
        }

        $itemObj = $this->model::find($item)->setHidden([]);
        $itemObj->update($request->all());
    
        return redirect()->route($this->tableName.'.index')
            ->with('success', 'Item successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        if (!GastropodAuth::check()) {
            return redirect('gastropod/login');
        }

        $itemObj = $this->model::find($item);
        $itemObj->delete();
        return redirect()->route($this->tableName.'.index')
            ->with('success', 'Item successfully deleted.');
    }
}
