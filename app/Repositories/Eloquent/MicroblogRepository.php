<?php

namespace Coyote\Repositories\Eloquent;

use Carbon\Carbon;
use Coyote\Microblog;
use Coyote\Repositories\Contracts\MicroblogRepositoryInterface;
use Coyote\Tag;
use Image;

/**
 * Class MicroblogRepository
 * @package Coyote\Repositories\Eloquent
 */
class MicroblogRepository extends Repository implements MicroblogRepositoryInterface
{
    public function model()
    {
        return 'Coyote\Microblog';
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*'])
    {
        $result = $this->prepare()->findOrFail($id);

        // generuje url do miniaturek dolaczonych do wpisu
        $result = $this->thumbnails($result);

        return $result;
    }

    /**
     * @param null|int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 10)
    {
        $this->applyCriteria();
        $result = $this->prepare()
                ->whereNull('parent_id')
                ->orderBy('microblogs.is_sponsored', 'DESC')
                ->orderBy('microblogs.id', 'DESC')
                ->paginate($perPage);

        // generuje url do miniaturek dolaczonych do wpisu
        $result = $this->thumbnails($result);
        // zostawiamy jedynie 2 ostatnie komentarze
        $result = $this->slice($result);

        return $result;
    }

    /**
     * Pobierz X ostatnich wpisow z mikrobloga przy czym sortowane sa one wedlug oceny. Metoda
     * ta jest wykorzystywana na stronie glownej serwisu
     *
     * @param int $limit
     * @return mixed
     */
    public function take($limit)
    {
        $result = $this->prepare()
                ->whereNull('parent_id')
                ->where('votes', '>=', 2)
                    ->orWhere('bonus', '>', 0)
                ->orderBy('microblogs.is_sponsored', 'DESC')
                ->orderBy('microblogs.score', 'DESC')
                ->take($limit)
                ->get();

        // generuje url do miniaturek dolaczonych do wpisu
        $result = $this->thumbnails($result);
        // zostawiamy jedynie 2 ostatnie komentarze
        $result = $this->slice($result);

        return $result;
    }

    /**
     * Pobiera $limit najpopularniejszych wpisow z mikrobloga z ostatniego tygodnia
     *
     * @param $limit
     * @return mixed
     */
    public function takePopular($limit)
    {
        $result = $this->prepare(false)
                ->whereNull('parent_id')
                ->where('microblogs.created_at', '>=', Carbon::now()->subWeek())
                ->orderBy('microblogs.score', 'DESC')
                ->take($limit)
                ->get();

        return $result;
    }

    /**
     * Pobranie komentarzy od danego wpisu w mikroblogu
     *
     * @param array $parentId
     * @return mixed
     */
    public function getComments($parentId)
    {
        return $this->prepare(false)->whereIn('parent_id', $parentId)->orderBy('id')->get();
    }

    /**
     * Metoda generuje URL do miniaturek jezeli zostaly one dolaczone do wpisu
     *
     * @param mixed $microblogs
     * @return mixed
     */
    public function thumbnails($microblogs)
    {
        $apply = function ($microblog) {
            if (isset($microblog->media['image'])) {
                $thumbnails = [];

                foreach ($microblog->media['image'] as $name) {
                    $thumbnails[$name] = Image::url(url('/storage/microblog/' . $name), 180, 180);
                }

                $microblog->thumbnails = $thumbnails;
            }
        };

        if ($microblogs instanceof Microblog) {
            $apply($microblogs);
        } else {
            $microblogs->each($apply);
        }

        return $microblogs;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->model->whereNull('parent_id')->count();
    }

    /**
     * @param int $userId
     * @return null|int
     */
    public function countForUser($userId)
    {
        return $userId ? $this->model->whereNull('parent_id')->where('user_id', $userId)->count() : null;
    }

    /**
     * @param bool $withComments
     * @return mixed
     */
    private function prepare($withComments = true)
    {
        $columns = ['microblogs.*', 'users.name', 'is_active', 'is_blocked', 'photo'];
        $columnThumb = 'mv.id AS thumbs_on';
        $columnWatch = 'mw.user_id AS subscribe_on';

        $userId = $this->app['auth']->id() ? \DB::raw($this->app['auth']->id()) : null;
        $with = [];

        if ($withComments) {
            $with['comments'] = function ($sql) use ($columns, $userId, $columnThumb) {
                $sql->join('users', 'users.id', '=', 'user_id')->orderBy('id', 'ASC');

                if ($userId) {
                    $sql->leftJoin('microblog_votes AS mv', function ($join) use ($userId) {
                        $join->on('mv.microblog_id', '=', 'microblogs.id')
                            ->where('mv.user_id', '=', $userId);
                    });

                    $columns = array_merge($columns, [$columnThumb]);
                }

                $sql->select($columns);
            };
        }

        if ($userId) {
            $columns = array_merge($columns, [$columnThumb, $columnWatch]);
        }

        $query = $this->model->select($columns)->with($with)->join('users', 'users.id', '=', 'user_id');

        if ($userId) {
            $query->leftJoin('microblog_votes AS mv', function ($join) use ($userId) {
                $join->on('mv.microblog_id', '=', 'microblogs.id')
                    ->where('mv.user_id', '=', $userId);
            })
            ->leftJoin('microblog_subscribers AS mw', function ($join) use ($userId) {
                $join->on('mw.microblog_id', '=', 'microblogs.id')
                    ->where('mw.user_id', '=', $userId);
            });
        }

        return $query;
    }

    /**
     * Zostawia jedynie 2 ostatnie komentarze do wpisu
     *
     * @param $microblogs
     * @return mixed
     */
    private function slice($microblogs)
    {
        foreach ($microblogs as &$microblog) {
            $microblog->comments_count = $microblog->comments->count();
            $microblog->comments = $microblog->comments->slice(-2, 2);
        }

        return $microblogs;
    }

    /**
     * Pobiera najpopularniejsze tagi w mikroblogach
     *
     * @return mixed
     */
    public function getTags()
    {
        return (new Microblog\Tag())
                ->select(['name', \DB::raw('COUNT(*) AS count')])
                ->join('tags', 'tags.id', '=', 'tag_id')
                ->join('microblogs', 'microblogs.id', '=', 'microblog_id')
                    ->whereNull('microblogs.deleted_at')
                    ->whereNull('microblogs.parent_id')
                ->groupBy('name')
                ->orderBy(\DB::raw('COUNT(*)'), 'DESC')
                ->limit(30)
                ->get()
                ->lists('count', 'name')
                ->toArray();
    }
}