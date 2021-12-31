<?php

namespace App\Models;

use App\Libraries\Notification;
use App\Libraries\Utilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;
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
     * @param $id
     * @return string[]
     */
    public function rule($id = null)
    {
        $rule = [
            'question' => 'required|string',
            'answer' => 'required|string',
            'status' => 'required|integer|between:1,2',
        ];

        return $rule;
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
     * Format data according to Datatable
     *
     * @param Collection $data
     * @return mixed
     * @throws \Exception
     */
    public function getDataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                if ($data->status == 1) {
                    return 'Active';
                } else {
                    return 'Inactive';
                }
            })
            ->addColumn('action', function ($data) {
                return '<a href="' . route("faqs.edit", [$data->tour_id, $data->id]) . '" type="button" class="btn btn-success btn-sm rounded-0 text-white edit" >
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="' . route("faqs.destroy", [$data->tour_id, $data->id]) . '" class="btn btn-danger btn-sm rounded-0 text-white delete" types="button" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
            })
            ->rawColumns(['name', 'place', 'action'])
            ->make(true);
    }
}
