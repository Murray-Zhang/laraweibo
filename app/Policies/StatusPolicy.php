<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    //判断当前用户id 和文章user_id 是否一致
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }
}
