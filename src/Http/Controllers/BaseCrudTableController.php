<?php

namespace RadFic\Gastropod\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class BaseCrudTableController extends Controller
{	
    protected $class;//class name of the model	
    protected $name;//table name
    protected $relations;//eloquent relations of the model 
    protected $relationsMap = [ //relations map for the rendering 
        'relation_name' => [
            'key' => "local_foreing_key",
            'field' => 'related_field_to_show'
        ]
    ];

	/**
	 * Constructor
	 * @param $item a model instance
	 */
    public function __construct($item)
    {
        if ($this->class == null) {
            $this->class = Users::class;
        }
        $this->name = $item->getTable();
        Paginator::useBootstrapFive();
    }

	/**
	 * load the eloquent relations of the model
	 */
    public function getRelations($item)
    {
        $this->relations = $item->getRelations();
    }

	/**
	 * explore the relations map to create entries in the front end
	 */
    public function exploreRelations($item)
    {
        foreach ($this->relationsMap as $relationName => $relationData) {
            $key = $relationData['key'];
            $relation = $item->$relationName;
            $relationTable = $relation->getTable();
            //print_r($item->$relationName);die();
            $relatedField = $relationData['field'];
            $fieldValue = ($relation!= null)?$relation->$relatedField:"";

            $newFieldName = $relationName."_".$relatedField."__REMOTE";

            $item->$newFieldName = "<a href='/gastropod/$relationTable/$relation->id'>$fieldValue</a>";
        }
    }

    public function formatShowData($showData)
    {
        $showData = \str_replace("[", "[<strong>", $showData);
        $showData = \str_replace("]", "</strong>]", $showData);
        return $showData;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchkey = $request->input('search-key', session('gastropod-index-search-key'));
        $searchField = $request->input('search-field', session('gastropod-index-search-field'));


        $itemsPerPage = $request->input('ipp');
        if (!is_numeric($itemsPerPage)) {//|| $itemsPerPage<10 || $itemsPerPage>100
            $itemsPerPage = session('gastropod-index-ipp', 10);
        } else {
            session(['gastropod-index-ipp' => $itemsPerPage]);
        }

        $query = $this->class::query();

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
            $this->exploreRelations($item);
        }

        $data = [
            'name'=> $this->name,
            'items' => $items
        ];
        return view('radfic.gastropod.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new $this->class();
        $columnNames = Schema::getColumnListing($item->getTable());

        $dropdowns = [];
        foreach ($columnNames as $columnName) {
            foreach ($this->relationsMap as $relationName => $relationData) {
                if ($relationData['key'] == $columnName) {
                    $dropdowns[$columnName] = [];

                    $dropdownData = $relationData['model']::get();
                    foreach ($dropdownData as $dd) {
                        $ddText = $relationData['field'];
                        $dropdowns[$columnName][] = [
                        'value' => $dd->id,
                        'text' => $dd->$ddText,
                    ];
                    }
                }
            }
        }

        //print_r(compact('dropdowns'));die();
        
        $data = [
            'name'=> $this->name,
            'columnNames' => $columnNames,
            'dropdowns' => $dropdowns
        ];
        return view('radfic.gastropod.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->class::create($request->all());
        return redirect()->route($this->name.'.index')
                        ->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        $itemObj = $this->class::find($item)->setHidden([]);
        foreach ($this->relationsMap as $relationName => $relationData) {
            $itemObj->$relationName;
        }
        $data = [
            'name'=> $this->name,
            'itemData' => $this->formatShowData(print_r($itemObj->toArray(), true))
        ];
        return view('radfic.gastropod.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($item)
    {
        $itemObj = $this->class::find($item)->setHidden([]);
        $columnNames = Schema::getColumnListing($itemObj->getTable());
        $dropdowns = [];
        foreach ($columnNames as $columnName) {
            foreach ($this->relationsMap as $relationName => $relationData) {
                if ($relationData['key'] == $columnName) {
                    $dropdowns[$columnName] = [];

                    $dropdownData = $relationData['model']::get();
                    foreach ($dropdownData as $dd) {
                        $ddText = $relationData['field'];
                        $dropdowns[$columnName][] = [
                        'value' => $dd->id,
                        'text' => $dd->$ddText,
                    ];
                    }
                }
            }
        }
        $data = [
            'name'=> $this->name,
            'item' => $itemObj->toArray(),
            'dropdowns' => $dropdowns
        ];
        return view('radfic.gastropod.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item)
    {
        $itemObj = $this->class::find($item)->setHidden([]);
        $itemObj->update($request->all());
    
        return redirect()->route($this->name.'.index')
            ->with('success', 'Item successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        $itemObj = $this->class::find($item);
        $itemObj->delete();
        return redirect()->route($this->name.'.index')
            ->with('success', 'Item successfully deleted.');
    }
}
