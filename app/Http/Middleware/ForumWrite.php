<?php

namespace Coyote\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;

class ForumWrite extends AbstractMiddleware
{
    /**
     * @var Gate
     */
    protected $gate;

    /**
     * @param Gate $gate
     */
    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $forum = $request->route('forum');

        if (!$forum->enable_anonymous && empty($request->user())) {
            return $this->login($request);
        }

        if ($forum->is_locked) {
            return $this->unauthorized($request);
        }

        $topic = $request->route('topic');
        if (!empty($topic)) {
            if ($topic->is_locked && !$this->gate->allows('update', $forum)) {
                return $this->unauthorized($request);
            }
        }

        return $next($request);
    }
}
