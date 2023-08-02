<?php

namespace App\Http\Controllers;

use App\Exports\AssetsExport;
use App\Imports\AssetsImport;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('Manage Assets')) {
            $assets = Asset::where('created_by', '=', \Auth::user()->creatorId())->get();
            return view('assets.index', compact('assets'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if (\Auth::user()->can('Create Assets')) {
            $employee   = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            return view('assets.create',compact('employee'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Assets')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'employee_id'=>'required',
                    'name' => 'required',
                    'purchase_date' => 'required',
                    'supported_date' => 'required',
                    'amount' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $employee_id = 0;
            if (!empty($request->employee_id)) {
                $employee_id = implode(',', $request->employee_id);
            }
            $assets                 = new Asset();
            $assets->employee_id    = $employee_id;
            $assets->name           = $request->name;
            $assets->purchase_date  = $request->purchase_date;
            $assets->supported_date = $request->supported_date;
            $assets->amount         = $request->amount;
            $assets->description    = $request->description;
            $assets->created_by     = \Auth::user()->creatorId();
            $assets->save();
            return redirect()->route('account-assets.index')->with('success', __('Assets successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Asset $asset)
    {
        //
    }


    public function edit($id)
    {

        if (\Auth::user()->can('Edit Assets')) {
            $asset = Asset::find($id);
            $employee   = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            return view('assets.edit', compact('asset','employee'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('Edit Assets')) {
            $asset = Asset::find($id);
            if ($asset->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'purchase_date' => 'required',
                        'supported_date' => 'required',
                        'amount' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $employee_id = 0;
                if (!empty($request->employee_id)) {
                    $employee_id = implode(',', $request->employee_id);
                }
                $asset->name           = $request->name;
                $asset->employee_id    = $employee_id;
                $asset->purchase_date  = $request->purchase_date;
                $asset->supported_date = $request->supported_date;
                $asset->amount         = $request->amount;
                $asset->description    = $request->description;
                $asset->save();

                return redirect()->route('account-assets.index')->with('success', __('Assets successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy($id)
    {
        if(\Auth::user()->can('Delete Assets'))
        {
            $asset = Asset::find($id);
            if($asset->created_by == \Auth::user()->creatorId())
            {
                $asset->delete();

                return redirect()->route('account-assets.index')->with('success', __('Assets successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function export()
    {
        $name = 'assets_' . date('Y-m-d i:h:s');
        $data = Excel::download(new AssetsExport(), $name . '.xlsx');

        return $data;
    }
    public function importFile(Request $request)
    {
        return view('assets.import');
    }
    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,txt',
        ];
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
       
        $assets = (new AssetsImport())->toArray(request()->file('file'))[0];

        $totalassets = count($assets) - 1;
        $errorArray    = [];

        for ($i = 1; $i <= $totalassets; $i++) {
            $asset = $assets[$i];

            $assetsData = Asset::where('name', $asset[0])->where('purchase_date', $asset[2])->first();


            if (!empty($assetsData)) {
                $errorArray[] = $assetsData;
            } else {
                $asset_data = new Asset();
                $asset_data->name=$asset[0];
                $asset_data->employee_id=$asset[1];
                $asset_data->purchase_date=$asset[2];
                $asset_data->supported_date=$asset[3];
                $asset_data->amount=$asset[4];
                $asset_data->description=$asset[5];
                $asset_data->created_by = Auth::user()->id;
                $asset_data->save();
            }
        }

        if (empty($errorArray)) {
            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        } else {

            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalassets . ' ' . 'record');


            foreach ($errorArray as $errorData) {
                $errorRecord[] = implode(',', $errorData->toArray());
            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }
}
