<?php

namespace App\Http\Controllers;

use App\Tips;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;

class TipsController extends Controller
{
    /**
     * Show all tips.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tips = Tips::all();
        return $this->sendResponse($tips->toArray(), 'Tips listed successfully.');
    }


    /**
     * Store a tip.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'guid' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $tips = Tips::create($input);
        return $this->sendResponse($tips->toArray(), 'Tip created successfully.');
    }


    /**
     * Display the tip.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tip = Tips::find($id);
        if (is_null($tip)) {
            return $this->sendError('Tip not found.');
        }
        return $this->sendResponse($tip->toArray(), 'Tip retrieved successfully.');
    }


    /**
     * Update the tip.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tips $tip)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'guid' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $tip->guid = $input['guid'];
        $tip->title = $input['title'];
        $tip->description = $input['description'];
        $tip->save();
        return $this->sendResponse($tip->toArray(), 'Tip updated successfully.');
    }


    /**
     * Remove tip.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $tip = Tips::find($id);
        if (is_null($tip)) {
            return $this->sendError('Tip not found.');
        }
        $tip = Tips::deleteTip($id);
        return $this->sendResponse([], 'Tip deleted successfully.');
    }
}
