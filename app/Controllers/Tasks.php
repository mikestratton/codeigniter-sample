<?php

namespace App\Controllers;

use App\Entities\Task;

class Tasks extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\TaskModel;
    }

    public function index()
    {
        $auth = service('auth');
        $user = $auth->getCurrentUser();

        $data = $this->model->getTasksByUserId($user->id);

        return view("Tasks/index", ['tasks' => $data]);
    }

    public function show($id)
    {
        $task = $this->getTaskOr404($id);

        return view("Tasks/show", ['task' => $task]);
    }

    public function new()
    {
        $task = new Task;
        return view('Tasks/new', [
            'task' => $task
        ]);
    }

    public function create()
    {
        $task = new Task($this->request->getPost());

        $user = service('auth')->getCurrentUser();

        $task->user_id = $user->id;

        if($this->model->insert($task)){
            return redirect()->to("/tasks/show/{$this->model->insertID}")
                ->with('info', 'Your task was successfully created.');
        }
        else {
            return redirect()->back()
                ->with('errors', $this->model->errors())
                ->with('warning', 'Invalid data')
                ->withInput();
        }


    }

    public function edit($id)
    {
        $task = $this->getTaskOr404($id);

        return view("Tasks/edit", ['task' => $task]);
    }

    public function update($id)
    {
        $task = $this->getTaskOr404($id);

        $post = $this->request->getPost();
        unset($post['user_id']);

        $task->fill($post);

        if(! $task->hasChanged()){
            return redirect()->back()
                             ->with('warning', 'Nothing to update')
                             ->withInput();
        }

        if($this->model->save($task)){
            return redirect()->to("/tasks/show/$id")
                ->with('info', 'Your task was successfully updated.');
        }
        else{
            return redirect()->back()
                             ->with('errors', $this->model->errors())
                             ->with('warning', 'Invalid data')
                             ->withInput();
        }

    }

    public function delete($id)
    {
        $task = $this->getTaskOr404($id);

        if($this->request->getMethod() === 'post'){
            $this->model->delete($id);
            return redirect()->to('/tasks')
                             ->with('info', 'Task deleted');
        }

        return view('Tasks/delete',[
            'task' => $task
        ]);
    }

    public function getTaskOr404($id)
    {
        $user = service('auth')->getCurrentUser();

        $task = $this->model->getTaskByUserId($id, $user->id);

        if($task === null){
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Task with id $id not found");
        }

        return $task;
    }
}
