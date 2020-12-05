<?php

namespace App\Http\Controllers\Backend;

use App\Model\NewsEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NewsEventController extends Controller
{

    public function view(){;
        $data['allData'] = NewsEvent::all();
        return view('backend.news_event.view-news-event',$data);
    }

    public function add(){
       return view('backend.news_event.add-news-event');
    }

    public function store(Request $request){

        $data = new NewsEvent();
        $data->date  = date('Y-m-d',strtotime($request->date));
        $data->short_title  = $request->short_title;
        $data->long_title  = $request->long_title;
        $data->created_by  = Auth::user()->id;
         if ($request->file('image')) {
                $file = $request->file('image');
                $fileName =date('YmdHi').$file->getClientOriginalExtension();
                $file->move(public_path('upload/news_images/'), $fileName);
                $data['image'] = $fileName;
            }
        $data->save();

        return redirect()->route('news_events.view')->with('success','Data Inserted Successfully');

    }


     public function edit($id){
            $editData = NewsEvent::findOrfail($id);
           return view('backend.news_event.edit-news-event',compact('editData'));

    }


    public function update(Request $request, $id ){
        $data = NewsEvent::findOrfail($id);
        $data->date  = date('Y-m-d',strtotime($request->date));
        $data->short_title  = $request->short_title;
        $data->long_title  = $request->long_title;
        $data->updated_by  = Auth::user()->id;
        if ($request->file('image')) {
                $file = $request->file('image');
                 @unlink(public_path('upload/news_images/'.$data->image));
                $fileName =date('YmdHi').$file->getClientOriginalExtension();
                $file->move(public_path('upload/news_images/'), $fileName);
                $data['image'] = $fileName;
            }

        $data->save();

        return redirect()->route('news_events.view')->with('success','Data updated Successfully');

    }

    public function delete($id){

        $news = NewsEvent::findOrfail($id);
        if(file_exists('upload/news_images/' . $news->image) AND ! empty($news->image)){
            unlink('upload/news_images/' . $news->image);
        }
        $news->delete();
       return redirect()->route('news_events.view')->with('success','Data Deleted Successfully');
    }





}
