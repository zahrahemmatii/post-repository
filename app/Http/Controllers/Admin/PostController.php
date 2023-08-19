<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Interfaces\PostInterface;
use App\Repositories\PostRepository;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\error;

class PostController extends Controller
{
    private array $messages;
    private PostInterface $repository;
    private string $base_url;

    public function __construct(PostInterface $repository)
    {
        $this->repository = $repository;
        $this->messages = Config::get('messages');
        $this->base_url = '/'.env('ADMIN_URL').'/post';
    }

    public function index()
    {
        try{
            $model = $this->repository->all_items();
        }
        catch (\Exception $exception)
        {
            Log::error($exception->getMessage());
            return response()->json([
               'message'=>$this->messages['not_found'],
                'status'=>false,
                'model'=>[]
            ]);
        }
        return response()->json([
           'message'=> 'نمایش پست ها',
            'status'=> true,
            'model'=>$model,
        ]);

    }

    public function show($id){
        try {
            $model = $this->repository->find_trash($id);
        }
        catch (\Exception $exception)
        {
            Log::error($exception->getMessage());
            return response()->json([
               'status'=>false,
               'message'=>$this->messages['not_found'],
                'model'=>[],
            ]);
        }
        return response()->json([
           'message'=>'نمایش پست',
           'status'=>true,
           'model'=>$model,
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $request = $request->validated();
        try{
           $model = $this->repository->store_item($request);
        }
        catch (\Exception $exception)
        {
            Log:error($exception->getMessage());
            return response()->json([
                'status'=>false,
                'message'=>$this->messages['fail_store'],

            ]);
        }
        return response()->json([
            'message'=>$this->messages['success_store'],
            'status'=>true,
            'data' => [
                'model' => $model
            ]
        ]);
    }


    public function update(UpdatePostRequest $request,$id)
    {
        $request = $request->validated();
        try
        {
             $this->repository->update_item($request,$id);
        }
        catch (\Exception $exception)
        {
            Log::error($exception->getMessage());

            return response()->json([
                'message'=>$this->messages['fail_update'],
                'status'=>false,
                'model'=>[],
            ]);
        }
        return response()->json([
           'status'=>true,
           'message'=>$this->messages['success_update'],
            'model' => $this->repository->find_trash($id)

        ]);
    }

    public function destroy($id)
    {
        try
        {
            $model = $this->repository->find_trash($id);
        }
        catch (\Exception $exception)
        {
            Log::error($exception->getMessage());
            return response()->json([
                'status'=>false,
                'message'=>$this->messages['not_found'],
                'error' => $exception->getMessage()
            ],404);
        }
        if($model->deleted_at)
        {
            try {
                $this->repository->restore_item($id);
            }
            catch (\Exception $exception)
            {

                Log::error($exception->getMessage());
                return response()->json([
                    'status'=>false,
                    'message'=>$this->messages['fail_restore'],
                    'error'=> $exception->getMessage(),
                ]);
            }
            return response()->json([
                'status'=>true,
                'message'=>$this->messages['success_restore'],
                'delete'=>false,
            ]);
        }
        try {
            $this->repository->delete_item($id);
        }
        catch (\Exception $exception)
        {
            Log::info($exception->getMessage());
            return response()->json([
                'status' => false,
                'message' => $this->messages['fail_delete'],
                'error' => $exception->getMessage()
            ],400);
        }
        return response()->json([
            'status' => true,
            'message' => $this->messages['success_delete'],
            'delete' => true
        ]);
    }
}
