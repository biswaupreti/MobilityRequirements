<?php

namespace App\Http\Controllers;

use App\ContextScenarioUserAppInteraction;
use App\ContextScenarioIdealWay;
use App\ContextSceneRelation;
use App\ContextRatings;
use App\ContextRemarksRelation;
use App\WaysOfInteractionVoting;
use App\Requirements;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class ContextController extends BaseController
{

    private $rules = ['scene' => 'required', 'user_id' => 'required', 'requirement_id' => 'required'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requirement_id = Input::get('requirement');
        $requirement = Requirements::select('scenario_id')->where('id', $requirement_id)->first();

        $context_ideal_way = ContextScenarioIdealWay::getContextIdealWayKeyValue();

        $breadcrumbs = array(
            'Projects' => "/projects",
            'All Requirements' => "/scenarios/$requirement->scenario_id",
            'All Context' => "requirements/$requirement_id"
        );

        return view('context.create', compact('requirement_id', 'context_ideal_way', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $checkContextExists = ContextScenarioUserAppInteraction::get()->where('context_id', $request->all()['context_id'])->toArray();
        if($checkContextExists){
            Session::flash('flash_message_warning', 'Sorry, this context already exists!!!');
            return redirect("requirements/$request->requirement_id");
        }

        ContextScenarioUserAppInteraction::create($request->all());

        Session::flash('flash_message', 'Congratulations, New context added successfully!');

        return redirect("requirements/$request->requirement_id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $context = ContextScenarioUserAppInteraction::select('context_scenario_user_app_interaction.*', 'CSR.scene')
                                                    ->leftJoin('context_scene_relation as CSR', function($join)
                                                    {
                                                        $join->on('CSR.context_id', '=', 'context_scenario_user_app_interaction.id');
                                                        $join->where('CSR.user_id','=', $this->user['id']);
                                                    })
                                                    ->where('context_scenario_user_app_interaction.id', $id)
                                                    ->get();
        if(count($context)) {
            $context = $context[0];
        }
        
        $requirement_id = $context->requirement_id;

//        if($context->user_id != $this->user['id']){
//            Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
//            return redirect("requirements/$requirement_id");
//        }

        $requirement = Requirements::select('scenario_id')->where('id', $requirement_id)->first();
        $context_ideal_way = ContextScenarioIdealWay::getContextIdealWayKeyValue();

        $breadcrumbs = array(
            'Projects' => "/projects",
            'All Requirements' => "/scenarios/$requirement->scenario_id",
            'All Context' => "requirements/$requirement_id"
        );

        return view('context.edit', compact('context', 'requirement_id', 'context_ideal_way', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $context = ContextScenarioUserAppInteraction::find($id);
        $updateData = $request->all();

        if(!isset($updateData["accompanying"])){
            $updateData["accompanying"] = '0';
        }
        if(!isset($updateData["intermittent"])){
            $updateData["intermittent"] = '0';
        }
        if(!isset($updateData["interrupting"])){
            $updateData["interrupting"] = '0';
        }

        $context->update($updateData);

        // insert into context_scene_relation
        $compareData = array('context_id' => $id, 'user_id' => $this->user['id']);
        $contextSceneRelationData = array(
            'context_id' => $id,
            'user_id' => $this->user['id'],
            'scene' => $updateData['scene']
            );

        ContextSceneRelation::updateOrCreate($compareData, $contextSceneRelationData);

        Session::flash('flash_message', 'Congratulations, Data updated successfully!');
        return redirect("requirements/$request->requirement_id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $context = ContextScenarioUserAppInteraction::findOrFail($id);
        $requirement_id = $context->requirement_id;

        if($context->user_id != $this->user['id']){
            Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
            return redirect("requirements/$requirement_id");
        }

        $context->delete();

        Session::flash('flash_message', 'Data successfully deleted!');

        return redirect("requirements/$requirement_id");
    }


    public function saveContextRatings(Request $request)
    {
        if($request->all()['ratings'] === ""){
            return response()->json(['status' => 'error']);
        }

        try{
            $user_id = $this->user['id'];
            $ratings_json = $request->all()['ratings'];

            $ratings_arr = json_decode($ratings_json);

            if(count($ratings_arr) > 0) {
                foreach($ratings_arr as $context_id => $rating) {
                    $data = array(
                        'context_id' => $context_id,
                        'user_id' => $user_id,
                        'rating' => $rating,
                    );
                    $_rating_exists = ContextRatings::where('user_id', $user_id)
                                                    ->where('context_id', $context_id)
                                                    ->exists();
                    if($_rating_exists){
                        ContextRatings::where('user_id', $user_id)
                            ->where('context_id', $context_id)
                            ->update($data);
                    } else{
                        ContextRatings::insert($data);
                    }
                }
            }
            return response()->json(['status' => 'success']);
        }
        catch(Exception $e) {
            return response()->json(['status' => 'error']);
        }
    }


    public function saveWaysOfInteractionVoting(Request $request)
    {
        try{
            $user_id = $this->user['id'];
            $context_id = $request->all()['context_id'];
            $data = array(
                'context_id' => $context_id,
                'user_id' => $user_id
            );
            if($request->all()['interaction'] == "1"){
                $data['accompanying'] = $request->all()['interaction_val'];
            } elseif($request->all()['interaction'] == "2"){
                $data['intermittent'] = $request->all()['interaction_val'];
            } else{
                $data['interrupting'] = $request->all()['interaction_val'];
            }

            $_rating_exists = WaysOfInteractionVoting::where('user_id', $user_id)
                                                ->where('context_id', $context_id)
                                                ->exists();
            if($_rating_exists){
                WaysOfInteractionVoting::where('user_id', $user_id)
                                ->where('context_id', $context_id)
                                ->update($data);
            } else{
                WaysOfInteractionVoting::insert($data);
            }
            return response()->json(['status' => 'success']);
        }
        catch(Exception $e){
            return response()->json(['status' => 'error']);
        }
    }


    public function saveRemarks(Request $request)
    {
        try{
            $context_id = $request->all()['context_id'];
            $data = array(
                'user_id' => $this->user['id'],
                'context_id' => $context_id,
                'remarks' => $request->all()['remarks'],
            );
//            dd($data);
//            ContextScenarioUserAppInteraction::where('id', $context_id)
//                                    ->update($data);
            ContextRemarksRelation::insert($data);

            return response()->json(['status' => 'success']);
        }
        catch(Exception $e){
            return response()->json(['status' => 'error']);
        }
    }

    public function remarksList(Request $request)
    {
        $context_id = $request->all()['context_id'];
        $user_id = $this->user['id'];

        $remarks = ContextRemarksRelation::select('context_remarks_relation.remarks', 'users.name')
                        ->leftJoin('users', 'users.id', '=', 'context_remarks_relation.id')
                        ->where('context_remarks_relation.context_id', $context_id)
                        ->where('context_remarks_relation.user_id', $user_id)
                        ->get()->toArray();
        if(count($remarks) > 0) {
            return response()->json(['remarks' => $remarks, 'status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }

    }

}
