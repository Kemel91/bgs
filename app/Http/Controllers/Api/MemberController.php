<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Member;
use App\Http\Requests\MemberRequest;
use App\Http\Resources\MemberResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberController extends Controller
{
    /**
     * Выдача всех участников
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return JsonResource::collection(Member::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return MemberResource
     */
    public function store(MemberRequest $request): MemberResource
    {
        dd($request->get('events'));
        $member = Member::create($request->validated());
        return new MemberResource($member);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResource
     */
    public function show($id)
    {
        $member = Member::query()->find($id);
        if (is_null($member)) {
            return new JsonResource(['error' => 'Not found member']);
        }
        return new MemberResource($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MemberRequest $request
     * @param int $id
     * @return JsonResource
     */
    public function update(MemberRequest $request, $id)
    {
        $member = Member::query()->find($id);
        if (is_null($member)) {
            return new JsonResource(['error' => 'Not found member']);
        }
        $member->fill($request->validated());
        $member->save();
        return new MemberResource($member);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResource
     * @throws \Exception
     */
    public function destroy($id)
    {
        $member = Member::query()->find($id);
        if (is_null($member)) {
            return new JsonResource(['error' => 'Not found member']);
        }
        $member->delete();
        return new JsonResource(null);
    }
}
