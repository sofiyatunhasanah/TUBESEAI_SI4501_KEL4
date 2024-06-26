<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Task extends Model
{
    protected $table = "tasks";
    protected $primaryKey = "id";
    public $incrementing = false;
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getTask()
    {
        try {
            $result = $this->where('user_id',Auth::user()->id)->get();
            if (count($result) > 0) {
                return $result;
            }
            return null;
        } catch (QueryException $ex) {
            Log::info("TaskModel Error", ["getTask" => $ex->getMessage(), "line" => $ex->getLine()]);
            return null;
        }
    }

    public function addTask($name, $due_date, $responsible_user, $status, $user_id)
    {
        try {
            $this->name = $name;
            $this->due_date = $due_date;
            $this->user_id = $user_id;
            $this->responsible_user = $responsible_user;
            $this->status = $status;
            if ($this->save()) {
                return true;
            }
            return false;
        } catch (QueryException $ex) {
            Log::info("TaskModel Error", ["addTask" => $ex->getMessage(), "line" => $ex->getLine()]);
            return false;
        }
    }

    public function getSingleTask($id)
    {
        try {
            $result = $this->where([['id', $id],['user_id',Auth::user()->id]])->first();
            if (isset($result) & !empty($result)) {
                return $result;
            }
            return null;
        } catch (QueryException $ex) {
            Log::info("TaskModel Error", ["getSingleTask" => $ex->getMessage(), "line" => $ex->getLine()]);
            return null;
        }
    }

    public function updateTask($id, $name, $due_date, $responsible_user, $status)
    {
        try {
            $result = $this->where('id', $id)
                ->update(['name' => $name, 'due_date' => $due_date, 'responsible_user' => $responsible_user, 'status' => $status]);
            if ($result) {
                return true;
            }
            return false;
        } catch (QueryException $ex) {
            Log::info("TaskModel Error", ["addTask" => $ex->getMessage(), "line" => $ex->getLine()]);
            return false;
        }
    }

    public function deleteTask($id)
    {
        try {
            $result = $this->where('id', $id)->delete();
            if ($result) {
                return true;
            }
            return false;
        } catch (QueryException $ex) {
            Log::info("TaskModel Error", ["deleteTask" => $ex->getMessage(), "line" => $ex->getLine()]);
            return false;
        }
    }

    public function getTotalTask()
    {
        try {
            $result = $this->where('user_id',Auth::user()->id)->count();
            if ($result > 0) {
                return $result;
            }
            return 0;
        } catch (QueryException $ex) {
            Log::info("TaskModel Error", ["getTotalProduct" => $ex->getMessage(), "line" => $ex->getLine()]);
            return 0;
        }
    }
    public function getCompleteTask()
    {
        try {
            $result = $this->where([['status',1],['user_id',Auth::user()->id]])
                ->count();
            if ($result > 0) {
                return $result;
            }
            return 0;
        } catch (QueryException $ex) {
            Log::info("TaskModel Error", ["getTotalProduct" => $ex->getMessage(), "line" => $ex->getLine()]);
            return 0;
        }
    }



}
