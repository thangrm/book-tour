<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\Destination;
use Exception;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    protected $destination;
    protected $notification;

    public function __construct(Destination $destination, Notification $notification)
    {
        $this->destination = $destination;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.destinations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.destinations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return false|\Illuminate\Http\RedirectResponse|string
     */
    public function store(Request $request)
    {
        $request->validate($this->destination->rules(), [],[
            'name' => 'tên điểm đến',
            'slug' => 'tên rút gọn',
            'image' => 'ảnh',
            'status' => 'trạng thái'
        ]);
        try {
            $this->destination->saveData($request);
            $this->notification->setMessage('Đã thêm điểm đến mới thành công', Notification::SUCCESS);

            return json_encode($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Tạo điểm đến không thành công', Notification::ERROR);

            return json_encode($this->notification->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $destination = Destination::findorFail($id);
        return view('admin.destinations.edit', compact('destination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return false|\Illuminate\Http\RedirectResponse|string
     */
    public function update(Request $request, $id)
    {
        Destination::findOrFail($id);
        $request->validate($this->destination->rules($id),[],[
            'name' => 'tên điểm đến',
            'slug' => 'tên rút gọn',
            'image' => 'ảnh',
            'status' => 'trạng thái'
        ]);

        try {
            $this->destination->saveData($request, $id);
            $this->notification->setMessage('Đã cập nhật điểm đến thành công', Notification::SUCCESS);

            return json_encode($this->notification->getMessage());
        } catch (Exception $e) {
            $this->notification->setMessage('Cập nhật điểm đến không thành công', Notification::ERROR);

            return json_encode($this->notification->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy($id)
    {
        return json_encode($this->destination->remove($id)->getMessage());
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            return $this->destination->getList($request);
        }
    }
}
