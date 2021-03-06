<?php

namespace Coyote\Repositories\Contracts;

interface FlagRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array $topicsId
     * @return mixed
     */
    public function takeForTopics(array $topicsId);

    /**
     * @param array $postsId
     * @return mixed
     */
    public function takeForPosts(array $postsId);

    /**
     * @param int $jobId
     * @return mixed
     */
    public function takeForJob($jobId);

    /**
     * @param int $wikiId
     * @return mixed
     */
    public function takeForWiki($wikiId);

    /**
     * @param $key
     * @param $value
     * @param int|null $userId
     */
    public function deleteBy($key, $value, $userId = null);
}
