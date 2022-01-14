<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    protected $faq;

    public function __construct(FAQ $faq)
    {
        $this->faq = $faq;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $tourId
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index($tourId)
    {
        return view('admin.faqs.index', compact('tourId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create($tourId)
    {
        return view('admin.faqs.create', compact('tourId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $tourId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $tourId)
    {
        $request->validate($this->faq->rules());
        $notification = $this->faq->storeFAQ($request, $tourId);

        if ($notification->isError()) {
            return back()->with($notification->getMessage())->withInput();
        }

        return redirect()->route('faqs.index', $tourId)->with($notification->getMessage());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $tourId
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($tourId, $id)
    {
        $faq = FAQ::findOrFail($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $tourId
     * @param $id
     * @return false|\Illuminate\Http\RedirectResponse|string
     */
    public function update(Request $request, $tourId, $id)
    {
        $request->validate($this->faq->rules($id));
        $notification = $this->faq->updateFAQ($request, $tourId, $id);

        if ($notification->isError()) {
            return back()->with($notification->getMessage())->withInput();
        }

        if ($request->ajax()) {
            return json_encode($notification->getMessage());
        }
        return redirect()->route('faqs.index', $tourId)->with($notification->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $tourId
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tourId, $id)
    {
        return $this->faq->remove($id);
    }

    /**
     * Process datatables ajax request.
     *
     * @param Request $request
     * @param $tourId
     * @return JsonResponse
     * @throws \Exception
     */
    public function getData(Request $request, $tourId)
    {
        if ($request->ajax()) {
            $data = $this->faq->getListFAQs($tourId);
            return $this->faq->getDataTable($data);
        }
    }
}
