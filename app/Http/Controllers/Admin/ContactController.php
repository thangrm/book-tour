<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contacts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return false|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|string
     */
    public function show($id)
    {
        return json_encode($this->contact->getById($id));
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
            return $this->contact->getList($request);
        }
    }
}
