<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\Music;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $music = Music::paginate(10);
        return response()->json($music,200);
       // return view('form',compact('music'));
    }

    public function getFileDB(){

        if ($handle = opendir(public_path('ringtone'))) {
         
            Schema::disableForeignKeyConstraints();
            DB::table('categories')->truncate();
            DB::table('musics')->truncate();
            Schema::enableForeignKeyConstraints();
            while (true == ($entry = readdir($handle))) {
            
                if ($entry != "." && $entry != "..") 
                    $cate =  DB::table('categories')->insertGetId(['name'=>$entry,'url'=>public_path('ringtone').'/'.$entry]);
                    if ($music = opendir(public_path('ringtone'.'/'.$entry))) {
                        while (false !== ($name = readdir($music))) {
                            if ($name != "." && $name != "..") {
                                DB::table('musics')->insert(['name'=>$name,'url'=>public_path('ringtone'.'/'.$entry).'/'.$name,'cate_id'=>$cate]);
                            }
                        }
                        closedir($music);
                    }
                
            }
            closedir($handle);
        }
    }

    public function listCate(){
         $cate = Categories::paginate(5);
        return response()->json($cate,200);
    }

    public function show($id){

        $musicCate = Categories::where('id',$id)->first();
        $music =  $musicCate->music()->get();
        return response()->json($music,200);
        
    }
    
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDownload($name)
    {  
    
        $music = Music::where('name','like','%'.$name.'%')->first();
        $cate = $music->category()->first();
      
       $file = (public_path().'/ringtone/'.$cate->name.'/'.$music->name);
  
       return response()->download($file);
       
    }

}
