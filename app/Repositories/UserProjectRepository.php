<?php

namespace App\Repositories;

use App\Models\UserProject;
use App\Traits\Response\ResponseHandlingTrait;
use Illuminate\Support\MessageBag;

class UserProjectRepository extends Repository
{
    use ResponseHandlingTrait;

    public function __construct()
    {
        parent::__construct(UserProject::class);
    }

    final public function findIdByParams(array $params): int
    {
        $userProject = UserProject::query()
            ->select('id')
            ->where([
                'user_id' => $params['user_id'],
                'project_id' => $params['project_id']
            ])->first();

        if (!$userProject) {
            $messages = new MessageBag();
            $messages->add('user_projects', __('Item is not available.'));
            $this->returnValidationErrors($messages);
        }

        return $userProject->id;
    }
}
