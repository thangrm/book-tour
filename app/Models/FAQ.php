<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faqs';
    protected $fillable = ['tour_id', 'question', 'answer', 'status'];
    protected $notification;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->notification = new Notification();
    }

    /**
     * Validate rules for FAQ
     *
     * @return string[]
     */
    public function rule(): array
    {
        return [
            'question' => 'required|string',
            'answer' => 'required|string',
            'status' => 'required|integer|between:1,2',
        ];
    }

    /**
     * Store a new FAQ for the tour
     *
     * @param Request $request
     * @param $tourId
     * @return Notification
     */
    public function storeFAQ(Request $request, $tourId)
    {
        $input = $request->only('question', 'answer', 'status');
        $input['tour_id'] = $tourId;
        $input = Utilities::clearAllXSS($input);

        $tour = Tour::find($tourId);
        if ($tour == null) {
            $this->notification->setMessage('Tour id not found', Notification::ERROR);

            return $this->notification;
        }

        $faq = $this->where('tour_id', $tourId)->where('question', $input['question'])->first();
        if ($faq != null) {
            $this->notification->setMessage('The question already exists', Notification::ERROR);

            return $this->notification;
        }

        if ($this->create($input)->exists) {
            $this->notification->setMessage('New faq added successfully', Notification::SUCCESS);
        } else {
            $this->notification->setMessage('FAQ addition failed', Notification::ERROR);
        }

        return $this->notification;
    }

    /**
     * Update the FAQ
     *
     * @param Request $request
     * @param $tourId
     * @param $id
     * @return Notification
     */
    public function updateFAQ(Request $request, $tourId, $id)
    {
        $this->notification->setMessage('FAQ update failed', Notification::ERROR);

        try {
            $faq = $this->findOrFail($id);
            $input = $request->only('question', 'answer', 'status');
            $input = Utilities::clearAllXSS($input);
            $faq->fill($input);

            if ($faq->save()) {
                $this->notification->setMessage('FAQ updated successfully', Notification::SUCCESS);
            }

        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == '1062') {
                $this->notification->setMessage('The question already exists', Notification::ERROR);
            }
        }

        return $this->notification;
    }

    /**
     * Delete the FAQ by id.
     *
     * @param $id
     * @return mixed
     */
    public function remove($id)
    {
        $faq = $this->findOrFail($id);
        return $faq->delete();
    }

    /**
     * Get a list of faqs
     *
     * @param $tourId
     * @return mixed
     */
    public function getListFAQs($tourId)
    {
        return $this->where('tour_id', $tourId)->oldest()->get();
    }

    /**
     * Format data to Datatable
     *
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function getDataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                return ($data->status == 1) ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $linkEdit = route("faqs.edit", [$data->tour_id, $data->id]);
                $linkDelete = route("faqs.destroy", [$data->tour_id, $data->id]);

                return view('components.action_link', compact(['id', 'linkEdit', 'linkDelete']));
            })
            ->rawColumns(['name', 'place', 'action'])
            ->make(true);
    }
}
