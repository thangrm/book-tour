<?php

namespace App\Models;

use App\Jobs\SendMailContactJob;
use App\Libraries\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'message', 'status'];

    /**
     * Rule for store new booking tour
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|regex:/^[a-z][a-z0-9_\.]{3,}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/',
            'phone' => 'required|regex:/(0)[0-9]{9,10}/',
            'message' => 'required|string',
        ];
    }

    /**
     * Get contact by ID
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $contact = Contact::findOrFail($id);
        if ($contact->status == 1) {
            $contact->status = 2;
            $contact->save();
        }

        return $contact;
    }

    /**
     * Store booking when user book tour
     *
     * @param Request $request
     * @return void
     */
    public function saveData(Request $request)
    {
        $input = Utilities::clearAllXSS($request->only(['name', 'email', 'phone', 'message']));
        $input['status'] = 1;

        $contact = Contact::create($input);
        dispatch(new SendMailContactJob($contact));
    }

    /**
     * Get a list of contact
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getList(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = $this->latest();
        if (!empty($search)) {
            $search = Utilities::clearXSS($search);
            $query->where(function ($sub) use ($search) {
                $sub->where('name', 'like', '%' . $search . '%');
                $sub->orwhere('email', 'like', '%' . $search . '%');
                $sub->orwhere('phone', 'like', '%' . $search . '%');
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $data = $query->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->setRowClass(function ($data) {
                return ($data->status == 1) ? 'font-weight-bold' : '';
            })
            ->addColumn('date', function ($data) {
                $date = Carbon::parse($data->created_at);
                return $date->diffForHumans();
            })
            ->addColumn('action', function ($data) {
                $link = route('contacts.show', $data->id);

                return view('components.button_modal', ['link' => $link, 'id' => $data->id, 'title' => 'Xem']);
            })
            ->make(true);
    }
}
