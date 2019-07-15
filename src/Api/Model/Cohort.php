<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBase;
use MoodleSDK\Api\ModelCRUD;

class Cohort extends ModelBase implements ModelCRUD
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $contextid;

    /**
     * @var string
     */
    private $idnumber;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    public function get(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_cohort_get_cohorts', [
            'cohortids' => [$this->getId()]
        ]);

        $results = json_decode($json);

        $this->fromObject($results[0]);

        return $this;
    }

    public function create(ApiContext $apiContext)
    {
        // TODO untested
//        $json = $this->apiCall($apiContext, 'core_cohort_create_cohorts', [
//            'cohorts' => [
//                $this->toArray()
//            ]
//        ]);
//
//        return $json;
    }

    public function update(ApiContext $apiContext)
    {
        // TODO untested
//        $json = $this->apiCall($apiContext, 'core_cohort_update_cohorts', [
//            'cohorts' => [
//                $this->toArray()
//            ]
//        ]);
//
//        return $json;
    }

    public function delete(ApiContext $apiContext)
    {
//        // TODO untested
//        $json = $this->apiCall($apiContext, 'core_cohort_delete_cohorts', [
//            'cohorts' => [$this->getId()]
//        ]);
//
//        return $json;
    }

    public function getMembers(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_cohort_get_cohort_members', [
            'cohortids' => [$this->getId()]
        ]);

        $result = json_decode($json);
        $userIds = $result[0]->userids;

        $userList = new UserList();
        $userList->findByIds($apiContext, $userIds);
        return $userList;
    }

    /**
     * Add a member to a Cohort
     *
     * @param ApiContext $apiContext
     * @param User $user
     * @return \stdClass
     */
    public function addMember(ApiContext $apiContext, User $user)
    {
        $member = [
            'cohorttype' => [
                'type' => 'id',
                'value' => $this->getId()
            ],
            'usertype' => [
                'type' => 'id',
                'value' => $user->getId(),
            ]
        ];
        $json = $this->apiCall($apiContext, 'core_cohort_add_cohort_members', [
            'members' => [
                $member
            ]
        ]);

        return json_decode($json);
    }

    /**
     * Delete a member from a Cohort
     *
     * @param ApiContext $apiContext
     * @param User $user
     * @return mixed
     */
    public function deleteMember(ApiContext $apiContext, User $user)
    {
        $member = [
            'cohortid' => $this->getId(),
            'userid' => $user->getId()
        ];
        $json = $this->apiCall($apiContext, 'core_cohort_delete_cohort_members', [
            'members' => [
                $member
            ]
        ]);

        return $json;
    }

    public function fromArrayExcludedProperties()
    {
        return ['descriptionformat', 'visible', 'component', 'theme'];
    }

    public function toArrayExcludedProperties()
    {
        return [];
    }

    // Properties Getters & Setters

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getContextid()
    {
        return $this->contextid;
    }

    /**
     * @param int $contextid
     */
    public function setContextid($contextid)
    {
        $this->contextid = $contextid;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdnumber()
    {
        return $this->idnumber;
    }

    /**
     * @param string $idnumber
     */
    public function setIdnumber($idnumber)
    {
        $this->idnumber = $idnumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

}
