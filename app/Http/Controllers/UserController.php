<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findUsers(Request $request)
    {
        $keyword = $request->query('search', '');

        $users  = $this->userRepository->searchUsers($keyword);

        return $users;
    }
}
