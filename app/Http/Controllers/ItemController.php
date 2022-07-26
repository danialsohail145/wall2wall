<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;

class ItemController extends Controller
{
    use ApiResponser;
    public function verify_cert(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'certificate_no' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error('Bad request', 400, $validator->errors());
        }
        $validated = $validator->validated();
        $item = Item::where(
            [
                'cert_no' => $validated['certificate_no']
            ]
        )->first();
        if (!$item) {
            return $this->error('Not found', 404);
        } else {
            return $this->success($item, 'Success');
        }
    }
    public function add_item(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            return $this->error('Access Forbidden', 401);
        } else {
            $validator = Validator::make($request->all(), [
                'sold' => 'required',
                'amount' => 'required|numeric',
                'certificate_no' => 'required|numeric|unique:items,cert_no,' . $request->item_id,
                'signer_name' => 'required',
                'item_name' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->error('Bad Request', 400, $validator->errors());
            }
            $validated = $validator->validated();
            $item=Item::create([
                'amount'=>$validated['amount'],
                'sold'=>$validated['sold'],
                'cert_no'=>$validated['certificate_no'],
                'signed_by'=>$validated['signer_name'],
                'name'=>$validated['item_name'],
                'user_id'=>Auth::user()->id
            ]);
            return $this->success($item,'Item created successfully',201);
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Item::latest()->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                        return $btn;
                    })
                    ->addColumn('user_id', function($row){

                        return $row->user->name;

                    })
                    ->rawColumns(['action', 'user'])
                    ->make(true);
        }

      

        return view('admin.home');
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'signed_by' => 'required',
            'cert_no' => 'required|numeric|unique:items,cert_no,' . $request->item_id,
            'amount' => 'required|numeric',
            'sold' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['fail'=>$validator->errors()]);
        }
        
        $validated = $validator->validated();

        // dd($validated);


        Item::updateOrCreate(['id' => $request->item_id],
                                ['name' => $validated['name'],
                                'signed_by' => $validated['signed_by'],
                                'cert_no' => $validated['cert_no'],
                                'amount' => $validated['amount'],
                                'user_id' => auth()->user()->id,
                                'sold' => $validated['sold']]);   

        return response()->json(['success'=>'Item saved successfully.']);

    }


    public function edit($id)
    {
        $product = Item::find($id);
        return response()->json($product);
    }

    public function destroy($id)
    {
        Item::find($id)->delete();
        return response()->json(['success'=>'Item deleted successfully.']);
    }


    public function verified()
    {
        $query = Item::where('cert_no', request()->cert_no);

        if ($query->exists()) {
            return response()->json(['success' => 'Verified', 'data' => $query->first()->toArray()]);
        }

        return response()->json(['fail' => 'No Record Found..']);

    }







    
}
