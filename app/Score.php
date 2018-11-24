<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    /**
     * 与模型关联的数据表
     */
   	protected $table = 'score';

   	/**
   	 * 该模型不被自动维护时间戳
   	 */
   	public $timestamps = false;
}
