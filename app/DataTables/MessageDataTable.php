<?php
/**
 * File name: CategoryDataTable.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\DataTables;

//use App\Models\Category;
use App\Models\Message;
use App\Models\CustomField;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Barryvdh\DomPDF\Facade as PDF;

class MessageDataTable extends DataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
        $dataTable = $dataTable
            // ->editColumn('image', function ($category) {
            //     return getMediaColumn($category, 'image');
            // })
        ->editColumn('updated_at', function ($message) {
            return getDateColumn($message, 'updated_at');
        })
        ->addColumn('action', 'message.datatables_actions')
        ->rawColumns(array_merge($columns, ['action']));

        return $dataTable;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
          [
            'data' => 'name',
            'title' => trans('lang.message_name'),
            'searchable' => false,
        ],
        [
            'data' => 'msg',
            'title' => trans('lang.message_msg'),
            'searchable' => false,
        ],
        [
            'data' => 'msg_id',
            'title' => trans('lang.message_msg_id'),
            'searchable' => false,
        ],
        [
            'data' => 'updated_at',
            'title' => trans('lang.message_updated_at'),
            'searchable' => false,
        ]
    ];

    $hasCustomField = in_array(Message::class, setting('custom_field_models', []));
    if ($hasCustomField) {
        $customFieldsCollection = CustomField::where('custom_field_model', Message::class)->where('in_table', '=', true)->get();
        foreach ($customFieldsCollection as $key => $field) {
            array_splice($columns, $field->order - 1, 0, [[
                'data' => 'custom_fields.' . $field->name . '.view',
                'title' => trans('lang.message_' . $field->name),
                'orderable' => false,
                'searchable' => false,
            ]]);
        }
    }
    return $columns;
}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Message $model)
    {
        return $model->newQuery()
        ->join('users','users.id','=','messages.outgoing_msg_id')
        ->groupBy('messages.outgoing_msg_id')
        ->select('messages.*','users.name','users.id');
                                // ->group_by('messages.outgoing_msg_id');

        // $model->newQuery()->with("user")
        //         ->join('driver_restaurants','driver_restaurants.user_id','=','drivers.user_id')
        //         ->whereIn('driver_restaurants.restaurant_id',$restaurantsIds)
        //         ->distinct('driver_restaurants.user_id')
        //         ->select('drivers.*');
       // dd() $model->newQuery());
        //   $data = DB::table('drivers')->select([
        //     'media.*',
        //      'driver_document.type',
        // ])->LeftJoin('driver_document','driver_document.user_id','=','drivers.user_id')->LeftJoin('media','media.id','=','driver_document.media_id')->where(['drivers.id'=>$id])->get()->toArray();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->addAction(['title'=>trans('lang.actions'),'width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
        ->parameters(array_merge(
            config('datatables-buttons.parameters'), [
                'language' => json_decode(
                    file_get_contents(base_path('resources/lang/' . app()->getLocale() . '/datatable.json')
                ), true)
            ]
        ));
    }

    /**
     * Export PDF using DOMPDF
     * @return mixed
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $pdf = PDF::loadView($this->printPreview, compact('data'));
        return $pdf->download($this->filename() . '.pdf');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'categoriesdatatable_' . time();
    }
}