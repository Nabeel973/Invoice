<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use Yajra\DataTables\DataTables;
use File;

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
            'amount' => 'required',
            'delivery_date' => 'required',
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
            'delivery_date.required' => 'Date Cannot be null',
            'amount.required' => 'Amount Cannot be null',
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

            $image =$request->file('image');
            $filenamewithextension = $image->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenametostore = $invoice->id. '.' . $extension;

            $img = Image::make($image)->resize(500, 500, function($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/'.$filenametostore));
            $invoice->image = $filenametostore;
            $invoice->save();

        }
        return redirect()->route('invoice.report')->with('success', 'Record Added Successfully');

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
           ->addColumn("action", function ($result) {

                   $dropdown = '';

                   if($result->image != null){
                   $dropdown .= '<button type="button" class="btn btn-primary view_image" rel="view_image" ><div class="align-items-center">View</div></button>';
                   }
                   else{
                       $dropdown.='-';
                   }

                   return $dropdown;

           })
          ;
        return $datatables->make(true);
    }

    public function image(Request $request){
     $invoice = Invoice::find($request->id);
         if($invoice){
            /* return response(public_path('images/'.$invoice->image));*/
             return asset('images/' . $invoice->image) ;
         }
    }
}
