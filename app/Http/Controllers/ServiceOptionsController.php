<?php

namespace App\Http\Controllers;

use App\Helper\WaitingApprovalHelper;
use App\Mail\EmailNotificationToAdmin;
use App\Service;
use App\Confirmation;
use App\ServiceImage;
use App\ServiceOption;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ServiceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ServiceOptionCollection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ServiceOptionsController extends Controller
{
    protected $rules = [
        'service' => [
            'title' => ['required', 'string', 'min:6', 'max:254'],
            // 'description' => ['required', 'string', 'min:6', 'max:254'],
        ],
    ];

    /**
     * Create a new ServiceController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('jwt.verify');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index($id)
    {
        $service = auth()->user()->provider->services()->find($id);
        // echo $service->id;
        return ServiceOptionCollection::collection($service->options()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ServiceResource
     * @throws ApiException
     */
    public function store(Request $request,$id)
    {
        // echo 'test';

        $validator = Validator::make($request->all(),[
            'title' => ['required', 'string', 'min:6', 'max:254'],
            // 'description' => ['required', 'string', 'min:6', 'max:254'],
            ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
            // throw new ApiException($validator->errors()->toArray(), 422);
        }


        $service = auth()->user()->provider->services()->find($id);
        if (!$service) {
            return response()->json([
                'message' => 'User service not found'
            ], 404);
            // throw new ApiException('User service not found', 404);
        }

        $serviceOption = new ServiceOption([
            'title' => $request->title,
            'price' => isset($request->price)? $request->price:NULL,
            'service_id'=> $id
        ]);

        if ($request->get('image')) {
            // $serviceImage = new ServiceOption();
            //using $service to store the image in service id
            $serviceOption->image = $serviceOption->saveImage($request->get('image'), 'service_option');
        }

        // data inserting into confirmation Table
        if(WaitingApprovalHelper::forResourceCreate(auth()->user(),$serviceOption)){

            // Need to introduce Email Trigger
            $emailContent=[
                'subject'=> 'Service Option Created',
                'greeting'=> 'Hello',
                'body'=> "A Service Option created,and it's waiting for your confirmation, please check in waiting approval list and take necessary action."
            ];

            Mail::to(env('ADMIN_EMAIL'))->send(new EmailNotificationToAdmin($emailContent));

            return response()->json(['message' => 'ok'], 200);
        }


        return response()->json(['message' => 'something went wrong!'], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return ServiceResource
     * @throws ApiException
     */
    public function update(Request $request,$service_id ,$id)
    {
        $validator = Validator::make($request->all(),[
            'title' => ['required', 'string', 'min:6', 'max:254'],
            // 'description' => ['required', 'string', 'min:6', 'max:254'],
            ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
            // throw new ApiException($validator->errors()->toArray(), 422);
        };
        // $service = auth()->user()->provider->services()->find($id);
        $service = auth()->user()->provider->services()->find($service_id);
        $serviceOption = $service->options()->find($id);
        if (!$serviceOption) {
            return response()->json([
                'message' => 'User service not found'
            ], 404);
            // throw new ApiException('User service not found', 404);
        }

        $serviceOption2 = new ServiceOption([
            'title' => $request->title,
            'price' => isset($request->price)? $request->price:NULL,
            'service_id'=>$service_id
        ]);

        if ($request->get('image')) {

            $serviceOption2->image = $serviceOption2->saveImage($request->get('image'), 'service_option');
        }

        // data updating into confirmation Table
        if(WaitingApprovalHelper::forResourceUpdate(auth()->user(),$serviceOption,$serviceOption2)){

            // Need to introduce Email Trigger
            $emailContent=[
                'subject'=> 'Service Option Updated',
                'greeting'=> 'Hello',
                'body'=> "A Service Option updated,and it's waiting for your confirmation, please check in waiting approval list and take necessary action."
            ];

            Mail::to(env('ADMIN_EMAIL'))->send(new EmailNotificationToAdmin($emailContent));

            return response()->json(['message' => 'ok'], 200);
        }

        return response()->json(['message' => 'something went wrong!'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws ApiException
     */
    public function destroy($service_id,$id)
    {
        $service = auth()->user()->provider->services()->find($service_id);
        $serviceOption = $service->options()->find($id);
        if (!$serviceOption) {
            return response()->json([
                'message' => 'User service not found'
            ], 404);
            // throw new ApiException('User service not found', 404);
        }
        $serviceOption->delete();
        return response()->json(['message' => 'ok'], 200);
    }
}
