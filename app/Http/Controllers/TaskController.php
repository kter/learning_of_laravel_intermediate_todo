<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\TaskRepository;
use App\Tasks;

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
     * @param TaskRepository $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
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

    /**
     * 指定タスクの削除
     *
     * @param Request $request
     * @param Task $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }

}
