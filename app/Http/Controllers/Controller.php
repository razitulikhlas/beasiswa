<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function makeNisn(){
        $nisn=DB::table('tbl_siswa')->count('id');
        $nomorPokokSekolah = '303501';
        $year = substr(date('Y'),-2);
        if($nisn == null){
            $nisn = '01';
        }else{
            $nisn = (int)$nisn+1;
            if($nisn <= 9){
                $nisn = '0'.$nisn;
            }else{
                    $nisn = ''.$nisn;
            }
        }
        $nisn = $year.$nomorPokokSekolah.$nisn;
        return $nisn;
    }
}
