<?php

namespace App\Http\Controllers;

use App\Models\DucumentUpload;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DucumentUploadController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('Manage Document'))
        {
            if(\Auth::user()->type == 'company')
            {
                $documents = DucumentUpload::where('created_by', \Auth::user()->creatorId())->get();
            }
            else
            {
                $userRole  = \Auth::user()->roles->first();
                $documents = DucumentUpload::whereIn(
                    'role', [
                              $userRole->id,
                              0,
                          ]
                )->where('created_by', \Auth::user()->creatorId())->get();
            }

            return view('documentUpload.index', compact('documents'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('Create Document'))
        {
            $roles = Role::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $roles->prepend('All', '0');

            return view('documentUpload.create', compact('roles'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {

        if(\Auth::user()->can('Create Document'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                                   'documents' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            if(!empty($request->documents))
            {

                $filenameWithExt = $request->file('documents')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('documents')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $dir = 'uploads/documentUpload/';
                $image_path = $dir . $fileNameToStore;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = '';
                $path = \Utility::upload_file($request,'documents',$fileNameToStore,$dir,[]);
                if($path['flag'] == 1){
                    $url = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }

            $document              = new DucumentUpload();
            $document->name        = $request->name;
            $document->document    = !empty($request->documents) ? $fileNameToStore : '';
            $document->role        = $request->role;
            $document->description = $request->description;
            $document->created_by  = \Auth::user()->creatorId();
            $document->save();

            return redirect()->route('document-upload.index')->with('success', __('Document successfully uploaded.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(DucumentUpload $ducumentUpload)
    {
        //
    }


    public function edit($id)
    {

        if(\Auth::user()->can('Edit Document'))
        {
            $roles = Role::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $roles->prepend('All', '0');

            $ducumentUpload = DucumentUpload::find($id);

            return view('documentUpload.edit', compact('roles', 'ducumentUpload'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

     public function update(Request $request, $id)
    {

        if(\Auth::user()->can('Edit Document'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                                   'documents' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $roles=$request->role;

            $document = DucumentUpload::find($id);

            if(!empty($request->documents))
            {

                $filenameWithExt = $request->file('documents')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('documents')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $dir = 'uploads/documentUpload/';
                $image_path = $dir . $fileNameToStore;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = '';
                $path = \Utility::upload_file($request,'documents',$fileNameToStore,$dir,[]);
                if($path['flag'] == 1){
                    $url = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }
                
                

            }


            $document->name = $request->name;
            if(!empty($request->documents))
            {
                $document->document = !empty($request->documents) ? $fileNameToStore : '';

            }

            $document->role        = $request->role;
            $document->description = $request->description;
            $document->save();

            return redirect()->route('document-upload.index')->with('success', __('Document successfully uploaded.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy($id)
    {
        if(\Auth::user()->can('Delete Document'))
        {
            $document = DucumentUpload::find($id);
            if($document->created_by == \Auth::user()->creatorId())
            {
                $document->delete();

                $dir = storage_path('uploads/documentUpload/');

                if(!empty($document->document))
                {
                    // unlink($dir . $document->document);
                }

                return redirect()->route('document-upload.index')->with('success', __('Document successfully deleted.'));
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
}
