<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class APIController extends Controller
{
    /**
     * responseSuccess
     *
     * Returns a generic success (200) JSON response
     * 
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($message = 'Success.')
    {
        return response()->json([
            'status' => 200,
            'message' => $message
        ], 200);
    }

    /**
     * responseResourceUpdated
     * 
     * Returns a resource updated success message (200) JSON reponse.
     * 
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseResourceUpdated($id, $message = 'Resource updated.')
    {
        return response()->json([
            'status' => 200,
            'id' => $id,
            'message' => $message
        ], 200);
    }

    /**
     * responseResourceCreated
     * 
     * Returns a reesource created (201) JSON response.
     * 
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseResourceCreated($id, $message = 'Resource created.')
    {
        return response()->json([
            'status' => 201,
            'id' => $id,
            'message' => $message
        ], 201);
    }

    /**
     * responseResourceDeleted
     *
     * Returns a reesource deleted (204) JSON response.
     * 
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseResourceDeleted($id, $message = 'Resource deleted.')
    {
        return response()->json([
            'status' => 204,
            'id' => $id,
            'message' => $message
        ], 200);
    }

    /**
     * responseUnauthorized
     * Returns an unauthorized (401) JSON response.
     * 
     * @param  array $errors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseUnauthorized($errors = ['Unauthorized'])
    {
        return response()->json([
            'status' => 401,
            'message' => $errors 
        ], 401);
    }
    
    /**
     * Returns a unprocessable entity (422) JSON response.
     *
     * @param  array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseUnprocessable($errors)
    {
        return response()->json([
            'status' => 422,
            'errors' => $errors,
        ], 422);
    }

    /**
     * Returns a server error (500) JSON response.
     *
     * @param  array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseServerError($errors = ['Server error.'])
    {
        return response()->json([
            'status' => 500,
            'errors' => $errors
        ], 500);
    }
}