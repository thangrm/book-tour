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

    /**
     * Validate rules for FAQ
     *
     * @return string[]
     */
    public function rules(int $id = null): array
    {
        $rule = [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'status' => 'required|integer|between:1,2',
        ];

        if ($id != null) {
            $rule['question'] = 'string|max:255';
            $rule['answer'] = 'string';
            $rule['status'] = 'integer|between:1,2';
        }

        return $rule;
    }

    /**
     * Save FAQ for the tour
     *
     * @param Request $request
     * @param $tourId
     * @param int $id
     * @return Notification
     */
    public function saveData(Request $request, $tourId, int $id = 0)
    {
        Tour::findOrFail($tourId);
        $input = $request->only('question', 'answer', 'status');
        $input['tour_id'] = $tourId;
        $input = Utilities::clearAllXSS($input);
        $faq = $this->findOrNew($id);

        $faq->fill($input);
        $faq->save();
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
        return $this->where('tour_id', $tourId)->latest()->get();
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
                $link = route('faqs.update', [$data->tour_id, $data->id]);
                $class = 'btn-switch-status';

                return view('components.button_switch',
                    ['status' => $data->status, 'link' => $link, 'class' => $class,]);
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
