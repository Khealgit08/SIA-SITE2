<?php

namespace App\Http\Controllers;

use App\Models\UserJob;
use Illuminate\Http\Request;
use App\Models\Usertbl;
use App\Traits\ApiResponser;
use Illuminate\Http\Response; 

Class UserController extends Controller {

    private $request;

    use ApiResponser;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function getUsers(){
        $users = Usertbl::all();
        return response()->json($users, 200);
    }

    /**
    * Return the list of users
    * @return Illuminate\Http\Response
    */
    public function index(){
        $users = Usertbl::all();
        return $this->successResponse($users);
    }

    public function add(Request $request ){
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0',
        ];
        
        $this->validate($request,$rules);
        // validate if Jobid is found in the table tbluserjob
        $userjob = UserJob::findOrFail($request->jobid);
        $user = Usertbl::create($request->all());
        return $this->successResponse($user,Response::HTTP_CREATED);
    }

    /**
    * Obtains and show one user
    * @return Illuminate\Http\Response
    */
    public function show($id){
        $user = Usertbl::findOrFail($id);
        return $this->successResponse($user);
    // old code
    /*
    $user = User::where('userid', $id)->first();
    if($user){
    return $this->successResponse($user);
    }
    {
    return $this->errorResponse('User ID Does Not Exists',
    Response::HTTP_NOT_FOUND);
    }
    */
    }

    /**
    * Update an existing author
    * @return Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender' => 'in:Male,Female',
            'jobid' => 'numeric|min:1|not_in:0',
        ];
    
        $this->validate($request, $rules);
    
        // Only check jobid if it was provided
        if ($request->has('jobid')) {
            $userjob = UserJob::findOrFail($request->jobid);
        }
    
        $user = Usertbl::findOrFail($id);
        $user->fill($request->all());
    
        if ($user->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        $user->save();
    
        return $this->successResponse($user);
    
        // old code
        /*
        $this->validate($request, $rules);
        //$user = User::findOrFail($id);
        $user = User::where('userid', $id)->first();
        if($user){
        $user->fill($request->all());
        // if no changes happen
        if ($user->isClean()) {
        return $this->errorResponse('At least one value must
        change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->save();
        return $this->successResponse($user);
        }
        {
        return $this->errorResponse('User ID Does Not Exists',
        Response::HTTP_NOT_FOUND);
        }
        */
    }

    /**
    * Remove an existing user
    * @return Illuminate\Http\Response
    */
    public function delete($id){
        $user = Usertbl::findOrFail($id);
        $user->delete();

        return $this->successResponse($user);
        // old code
        /*
        $user = User::where('userid', $id)->first();
        if($user){
        $user->delete();
        return $this->successResponse($user);
        }
        {
        return $this->errorResponse('User ID Does Not Exists',
        Response::HTTP_NOT_FOUND);
        }
        */
    }
}