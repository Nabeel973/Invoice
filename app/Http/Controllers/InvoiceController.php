<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index');
    }

    public function submit(Request $request)
    {
        $rules = [
            'supplier_name' => 'required|max:100',
            'invoice_number' => 'required|max:20',
            'submit_by' => 'required|max:20',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];

        $messages = [
            'supplier_name.required' => 'Supplier Name is Required',
            'invoice_number.required' => 'Invoice Number is Required',
            'submit_by.required' => 'Name is Required',
            'supplier_name.max' => 'Supplier Name cannot be long then 100 characters',
            'invoice_number.max' => 'Number cannot be long then 20 characters',
            'submit_by.max' => 'Name cannot be long then 20 characters',
        ];

        $validate = Validator::make($request->all(), $rules, $messages);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $invoice = new Invoice();
        $invoice->supplier_name = $request->supplier_name;
        $invoice->invoice_no = $request->invoice_number;
        $invoice->delivery_date = date("Y-m-d", strtotime($request->delivery_date));
        $invoice->amount = $request->amount;
        $invoice->submitted_by = $request->submit_by;
        $invoice->items_delivered = $request->items_delivered;
        $invoice->save();

        if($request->hasFile('image')){

            $invoice->image = $invoice->id;
            $invoice->save();
        }
        return view('invoices.report')->with('success', 'Record Added Successfully');

    }

    public function report_index()
    {
        return view('invoices.report');
    }

    public function list()
    {
        $invoices = Invoice::select('id', 'supplier_name', 'invoice_no', 'delivery_date', 'amount', 'items_delivered', 'image', 'submitted_by');

        $datatables = Datatables::of($invoices)
            ->editColumn('items_delivered', function ($invoice) {
                return (($invoice->items_delivered) ? 'Yes' : 'No');
            })
            ->editColumn('image', function ($invoice) {

                $image = '';
                if($invoice->image != null){
                    $image .= '<div class="text-center"><button type="button" class="btn btn-primary btn-sm picture" data-link="' .'public/img/'.$invoice->image . '"><i class="la la-image"></i> View</button></div>';

                    return $image;
                }
            });
        return $datatables->make(true);
    }
}
