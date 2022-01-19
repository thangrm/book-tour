<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Notification;
use App\Models\FAQ;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class FAQController extends Controller
{
    protected $faq;
    protected $notification;

    public function __construct(FAQ $faq, Notification $notification)
    {
        $this->faq = $faq;
        $this->notification = $notification;
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
        $this->notification->setMessage('FAQ creation failed', Notification::ERROR);

        try {
            $this->faq->saveData($request, $tourId);
            $this->notification->setMessage('New faq added successfully', Notification::SUCCESS);

            return redirect()->route('faqs.index', $tourId)->with($this->notification->getMessage());
        } catch (QueryException $e) {
            $exMessage = $e->getMessage();

            if ($e->errorInfo[1] == '1062') {
                return back()->withErrors(['question' => 'The question already exists'])->withInput();
            }
        } catch (Exception $e) {
            $exMessage = $e->getMessage();
        }

        return back()
            ->with('exception', $exMessage)
            ->with($this->notification->getMessage())
            ->withInput();
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
        $this->notification->setMessage('FAQ update failed', Notification::ERROR);

        try {
            $this->faq->saveData($request, $tourId, $id);
            $this->notification->setMessage('FAQ updated successfully', Notification::SUCCESS);

            if ($request->ajax()) {
                return response()->json($this->notification->getMessage());
            }
            return redirect()->route('faqs.index', $tourId)->with($this->notification->getMessage());
        } catch (QueryException $e) {
            $exMessage = $e->getMessage();

            if ($e->errorInfo[1] == '1062') {
                return back()->withErrors(['question' => 'The question already exists'])->withInput();
            }
        } catch (Exception $e) {
            $exMessage = $e->getMessage();
        }

        if ($request->ajax()) {
            return response()->json($this->notification->getMessage());
        }
        
        return back()
            ->with('exception', $exMessage)
            ->with($this->notification->getMessage())
            ->withInput();
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
