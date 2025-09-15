<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBase;
use MoodleSDK\Api\ModelCRUD;

class Group extends ModelBase implements ModelCRUD
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $idnumber;

    public function get(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_group_get_groups', [
            'groupids' => [$this->getId()]
        ]);

        $results = json_decode($json);

        $this->fromObject($results[0]);

        return $this;
    }

    public function create(ApiContext $apiContext)
    {
        // TBD
    }

    public function update(ApiContext $apiContext)
    {
        // TBD
    }

    public function delete(ApiContext $apiContext)
    {
        // TBD
    }

    /**
     * Add a member to a Group
     *
     * @return \stdClass
     */
    public function addMember(ApiContext $apiContext, User $user)
    {
        $member = [
            'groupid' => $this->getId(),
            'userid' => $user->getId()
        ];
        $json = $this->apiCall($apiContext, 'core_group_add_group_members', [
            'members' => [
                $member
            ]
        ]);

        return json_decode($json);
    }

    public function fromArrayExcludedProperties()
    {
        return ['customfields'];
    }

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

}
