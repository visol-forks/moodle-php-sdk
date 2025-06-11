<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBaseList;

class CohortList extends ModelBaseList
{

    /**
     * Fetch all cohorts
     *
     * @return $this
     */
    public function all(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_cohort_get_cohorts', [
            'cohortids' => [
            ]
        ]);

        $this->fromJSON($json);
        return $this;
    }

}
