<?php

namespace RadFic\Gastropod;

use RadFic\Gastropod\GastropodAuth;

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
    protected $relationsMap = [//relations map for the views
        'profile' => [
            'key' => "profile_id",
            'field' => 'name',
            'model' => Profile::class
        ]
    ];

    /**
     * Constructor
     * @param $item a model instance
     */
    public function __construct($modelClass, $relationsMap)
    {
		GastropodAuth::check();//redirect to login if not logged & gastronaut
        $this->model = $modelClass;
        $item = new $this->model();//an empty eloquent instance
		$this->relations = $item->getRelations();
		$this->relationsMap = $relationsMap;
        $this->tableName = $item->getTable();
        Paginator::useBootstrap();
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
     * Display a listing of the records in the table.
     *
	 * @param \Illuminate\Http\Request 
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
            $this->exploreRelations($item);
        }

        $data = [
            'name'=> $this->tableName,
            'items' => $items
        ];
        return view('gastropod.index', $data);
    }


	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new $this->model();
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
        
        $data = [
            'name'=> $this->tableName,
            'columnNames' => $columnNames,
            'dropdowns' => $dropdowns
        ];
        return view('gastropod.create', $data);
    }


	/**
     * Store a newly created item in the database.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->model::create($request->all());
        return redirect()->route($this->tableName.'.index')
                        ->with('success', 'Item created successfully.');
    }


	/**
     * Display the specified item.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        $itemObj = $this->model::find($item)->setHidden([]);
        foreach ($this->relationsMap as $relationName => $relationData) {
            $itemObj->$relationName;
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
     * @param  Illuminate\Database\Eloquent\Model
     * @return \Illuminate\Http\Response
     */
    public function edit($item)
    {
        $itemObj = $this->model::find($item)->setHidden([]);
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
            'name'=> $this->tableName,
            'item' => $itemObj->toArray(),
            'dropdowns' => $dropdowns
        ];
        return view('gastropod.edit', $data);
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
        $itemObj = $this->model::find($item)->setHidden([]);
        $itemObj->update($request->all());
    
        return redirect()->route($this->tableName.'.index')
            ->with('success', 'Item successfully updated.');
    }

	/**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        $itemObj = $this->model::find($item);
        $itemObj->delete();
        return redirect()->route($this->tableName.'.index')
            ->with('success', 'Item successfully deleted.');
    }
}
