<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    protected $typeTour;

    public function __construct(Type $typeTour)
    {
        $this->typeTour = $typeTour;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.types.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return false|\Illuminate\Http\RedirectResponse|string
     */
    public function store(Request $request)
    {
        $request->validate($this->typeTour->rules());
        $notification = $this->typeTour->storeType($request);

        return json_encode($notification->getMessage());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return false|\Illuminate\Http\RedirectResponse|string
     */
    public function update(Request $request, int $id)
    {
        $request->validate($this->typeTour->rules($id));
        $notification = $this->typeTour->updateType($request, $id);

        return json_encode($notification->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return String
     */
    public function destroy($id)
    {
        return json_encode($this->typeTour->remove($id)->getMessage());
    }

    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->typeTour->getListTypes($request);
            return $this->typeTour->getDataTable($data);
        }
    }
}
