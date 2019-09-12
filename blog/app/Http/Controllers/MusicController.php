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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  




    public function storeCate(){
   
        if ($handle = opendir(public_path('ringtone'))) {
            Schema::disableForeignKeyConstraints();
            DB::table('categories')->truncate();
            DB::table('musics')->truncate();
            Schema::enableForeignKeyConstraints();
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    DB::table('categories')->insert(['name'=>$entry,'url'=>public_path('ringtone').'/'.$entry]);
                }
            }
            closedir($handle);
        }
    }

    public function storeMusic($name)
    {
        $cate = Categories::all();
        foreach ($cate as $cates){
            if($cates->name === $name){
                if ($handle = opendir(public_path('ringtone'.'/'.$name))) {
                    while (false !== ($entry = readdir($handle))) {
                        if ($entry != "." && $entry != "..") {
                            DB::table('musics')->insert(['name'=>$entry,'url'=>public_path('ringtone'.'/'.$name).'/'.$entry,'cate_id'=>$cates->id]);
                        }
                    }
                    closedir($handle);
                }
            }
        }
    }

    public function getFile(){

        if ($handle = opendir(public_path('ringtone'))) {
         
            Schema::disableForeignKeyConstraints();
            DB::table('categories')->truncate();
            DB::table('musics')->truncate();
            Schema::enableForeignKeyConstraints();
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
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
            }
            closedir($handle);
        }
    }

    public function listCate(){
        $cate = $cate = Categories::all();
        return response()->json($cate,200);
    }

    public function listMusicCate($name){

        $musicCate = Categories::where('name',$name)->first();
        $music =  $musicCate->music()->get();
        return response()->json($music,200);
        
    }
    
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
       
    }

}
