<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBaseList;

class CourseList extends ModelBaseList
{

    /**
     * Fetch all courses
     *
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
     * Find courses by Ids
     *
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
        return $this->apiCall($apiContext, 'core_course_update_courses', [
            'courses' => $coursesToUpdate
        ]);
    }

    public function bulkDelete(ApiContext $apiContext, array $idsOfCoursesToDelete)
    {
        return $this->apiCall($apiContext, 'core_course_delete_courses', [
            'courseids' => $idsOfCoursesToDelete
        ]);
    }
}
