<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\Type;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    protected $typeTour;
    protected $notification;

    public function __construct(Type $typeTour, Notification $notification)
    {
        $this->typeTour = $typeTour;
        $this->notification = $notification;
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
        try {
            $this->typeTour->saveData($request);
            $this->notification->setMessage('New type added successfully', Notification::SUCCESS);
        } catch (Exception $e) {
            $this->notification->setMessage('Type creation failed', Notification::ERROR);
        }

        return json_encode($this->notification->getMessage());
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
        try {
            $this->typeTour->saveData($request, $id);
            $this->notification->setMessage('Type updated successfully', Notification::SUCCESS);
        } catch (Exception $e) {
            $this->notification->setMessage('Type creation failed', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return String
     */
    public function destroy($id)
    {
        try {
            $codeMessage = $this->typeTour->remove($id);
            $this->notification->setMessage('Type deleted successfully', Notification::SUCCESS);

            if ($codeMessage == 2) {
                $this->notification->setMessage('The type has tours that cannot be deleted', Notification::ERROR);
            }
        } catch (Exception $e) {
            $this->notification->setMessage('Type delete failed', Notification::ERROR);
        }

        return response()->json($this->notification->getMessage());
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
