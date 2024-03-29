<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Distribusisoal_ujian_tmp extends Model
{
  protected $guarded = [];
  protected $table = 'ujian_distribusisoals_tmp';

  public function soal()
  {
    return $this->belongsTo('App\Models\Soal', 'id_soal');
  }
  public function kelas()
  {
    return $this->belongsTo('App\Models\Kelas', 'id_kelas');
  }
  public function jawabUser()
  {
    return $this->belongsTo('App\Models\Jawab', 'id_soal', 'id_soal'); //->where('id_user', Auth::user()->id);
  }
}
