<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Member;
use App\Http\Requests\MemberRequest;
use App\Http\Resources\MemberResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Управление участниками мероприятий
 * Class MemberController
 * @package App\Http\Controllers\Api
 */
class MemberController extends Controller
{
    /**
     * Выдача всех участников
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $members = Member::query();
        if ($request->get('event_id')) {
            $members->whereHas('events', function ($query) use ($request) {
                $query->where('id', (int)$request->get('event_id'));
            });
        }
        return MemberResource::collection($members->get());
    }

    /**
     * Добавление нового участника
     *
     * @param MemberRequest $request
     * @return MemberResource
     */
    public function store(MemberRequest $request): MemberResource
    {
        $member = Member::create($request->validated());
        $member = $this->attachEvents($member, $request->get('events'));
        return new MemberResource($member);
    }

    /**
     * Вывод определенного участника
     *
     * @param int $id
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
     * Обновление информации об участнике
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
        $member = $this->attachEvents($member, $request->get('events'));
        return new MemberResource($member);
    }

    /**
     * Удаление участника
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

    /**
     * Присоединяем события
     *
     * @param Member $member
     * @param array $events
     * @return Member
     */
    private function attachEvents(Member $member, array $events): Member
    {
        if (!is_null($events)) {
            $member->events()->detach();
            foreach ($events as $event) {
                $member->events()->attach($event);
            }
        }
        return $member;
    }
}
