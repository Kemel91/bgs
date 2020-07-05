<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Http\Resources\MemberResource;
use App\Mail\MemberCreated;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Mail;

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
        Mail::to($request->get('email'))->send(new MemberCreated($member));
        return new MemberResource($member);
    }

    /**
     * Вывод определенного участника
     *
     * @param int $id
     * @return MemberResource
     * @throws \Throwable
     */
    public function show($id): MemberResource
    {
        $member = Member::query()->find($id);
        throw_if(!$member, NotFoundException::class);
        return new MemberResource($member);
    }

    /**
     * Обновление информации об участнике
     *
     * @param MemberRequest $request
     * @param int $id
     * @return MemberResource
     * @throws \Throwable
     */
    public function update(MemberUpdateRequest $request, $id): MemberResource
    {
        $member = Member::query()->find($id);
        throw_if(!$member, NotFoundException::class);
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
     * @throws \Throwable
     */
    public function destroy($id): JsonResource
    {
        $member = Member::query()->find($id);
        throw_if(!$member, NotFoundException::class);
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
    private function attachEvents(Member $member, ?array $events): Member
    {
        if (is_array($events)) {
            $member->events()->detach();
            foreach ($events as $event) {
                $member->events()->attach($event);
            }
        }
        return $member;
    }
}
