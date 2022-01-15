<?php

namespace App\Models;

use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Contact extends Model
{
    use HasFactory;

    public function getContact($id)
    {
        $contact = Contact::findOrFail($id);
        if ($contact->status == 1) {
            $contact->status = 2;
            $contact->save();
        }
        
        return $contact;
    }

    /**
     * Get a list of destinations
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
            ->addColumn('action', function ($data) {
                $link = route('contacts.show', $data->id);

                return view('components.button_modal', ['link' => $link, 'id' => $data->id, 'title' => 'View']);
            })
            ->make(true);
    }
}
