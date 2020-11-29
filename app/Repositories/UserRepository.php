<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 */
class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function updateRelevanceByUuid(string $uuid, int $relevance)
    {
        $this->model
            ->where('uuid', $uuid)
            ->update(['relevance' => $relevance]);
    }

    public function searchUsers(string  $keyword)
    {
        $users = User::search($keyword)
            ->orderBy('relevance', 'DESC')
            ->orderBy('username', 'ASC')
            ->paginate(15);

        return $users;
    }
}
