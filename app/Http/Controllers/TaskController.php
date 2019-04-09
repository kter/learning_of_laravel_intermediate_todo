<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{

    /**
     * タスクリポジトリーインスタンス
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * 新しいコントローラインスタンスの生成
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * ユーザーの全タスクをリスト表示
     *
     * @params Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    /**
     * 新タスク作成
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // バリデーション失敗時のリダイレクトやエラー内容のセッション記録も自動で行ってくれる
        $this->validate($request, [
            'name' => 'required|max:255',
    ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect(('/tasks'));
    }
}
