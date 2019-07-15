<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBaseList;

class CourseList extends ModelBaseList
{

    /**
     * Fetch all courses
     *
     * @param ApiContext $apiContext
     * @return $this
     */
    public function all(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_course_get_courses', [
            'options' => [
                'ids' => [
                ]
            ]
        ]);

        $this->fromJSON($json);
        return $this;
    }

    /**
     * Fetch one course
     *
     * @param int $courseId
     * @param ApiContext $apiContext
     * @return $this
     */
    public function one(int $courseId, ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_course_get_courses', [
            'options' => [
                'ids' => [$courseId]
            ]
        ]);

        $this->fromJSON($json);
        return $this;
    }

    /**
     * Find courses by Ids
     *
     * @param ApiContext $apiContext
     * @param array $courseIds
     * @return $this
     */
    public function findByIds(ApiContext $apiContext, array $courseIds)
    {
        $json = $this->apiCall($apiContext, 'core_course_get_courses', [
            'options' => [
                'ids' => $courseIds
            ]
        ]);

        $this->fromJSON($json);
        return $this;
    }

    public function searchByUser(ApiContext $apiContext, User $user)
    {
        $json = $this->apiCall($apiContext, 'core_enrol_get_users_courses', [
            'userid' => $user->getId()
        ]);

        $this->fromJSON($json);
        return $this;
    }

    public function bulkUpdate(ApiContext $apiContext, array $coursesToUpdate)
    {
        $json = $this->apiCall($apiContext, 'core_course_update_courses', [
            'courses' => $coursesToUpdate
        ]);
        return $json;
    }

    public function bulkDelete(ApiContext $apiContext, array $idsOfCoursesToDelete)
    {
        $json = $this->apiCall($apiContext, 'core_course_delete_courses', [
            'courseids' => $idsOfCoursesToDelete
        ]);
        return $json;
    }
}
