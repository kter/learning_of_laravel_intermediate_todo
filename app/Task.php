<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * 複数代入を行う属性
     *
     * @var array
     */
    // モデル保存時の保存ができる属性（ホワイトリスト）
    protected $fillable = ['name'];

    /**
     * タスク所有ユーザーの取得
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
