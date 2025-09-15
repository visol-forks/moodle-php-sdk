<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBase;
use MoodleSDK\Api\ModelCRUD;

class Course extends ModelBase implements ModelCRUD
{

    private $id;

    /** @var string */
    private $idnumber;

    private $shortName;
    private $displayName;
    private $fullName;
    private $format;
    private $summary;
    private $summaryFormat;
    private $summaryFiles;
    private $overviewFiles;
    private $categoryId;
    private $startDate;
    private $endDate;
    private $contacts;

    /** @var integer */
    private $visible;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var array
     */
    private $courseFormatOptions;

    public function get(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_course_get_courses_by_field', [
            'field' => 'shortname',
            'value' => $this->getShortName()
        ]);

        $results = json_decode($json);

        $this->fromObject($results->courses[0]);

        return $this;
    }

    /**
     * Get a single course by the value of a given field
     *
     * @param string $fieldName
     * @param $value
     * @return $this
     */
    public function findOneByField(ApiContext $apiContext, $fieldName, $value)
    {
        $json = $this->apiCall($apiContext, 'core_course_get_courses_by_field', [
            'field' => $fieldName,
            'value' => $value
        ]);

        $results = json_decode($json);

        if (empty($results->courses)) {
            return null;
        }

        $this->fromObject($results->courses[0]);

        return $this;
    }

    public function create(ApiContext $apiContext)
    {
        return $this->apiCall($apiContext, 'core_course_create_courses', [
            'courses' => [
                $this->toArray()
            ]
        ]);
    }
 
    public function update(ApiContext $apiContext)
    {
        return $this->apiCall($apiContext, 'core_course_update_courses', [
            'courses' => [
                $this->toArray()
            ]
        ]);
    }

    public function delete(ApiContext $apiContext)
    {
        return $this->apiCall($apiContext, 'core_course_delete_courses', [
            'courseids' => [$this->getId()]
        ]);
    }

    public function enrolledUsers(ApiContext $apiContext)
    {
        $json = $this->apiCall($apiContext, 'core_enrol_get_enrolled_users', [
            'courseid' => $this->getId()
        ]);
        
        $userList = new UserList();
        $userList->fromJSON($json);

        return $userList;
    }

    public function enrolUser(ApiContext $apiContext, User $user, $roleId)
    {
        $json = $this->apiCall($apiContext, 'enrol_manual_enrol_users', [
            'enrolments' => [
                Enrolment::instance()
                                ->setCourseId($this->getId())
                                ->setUserId($user->getId())
                                ->setRoleId($roleId)
                                ->setTimeStart(null)
                                ->setTimeEnd(null)
                                ->toArray()
            ]
        ]);
        
        return json_decode($json);
    }

    public function unenrolUser(ApiContext $apiContext, User $user, $roleId)
    {
        return $this->apiCall($apiContext, 'enrol_manual_unenrol_users', [
            'enrolments' => [
                Enrolment::instance()
                                ->setCourseId($this->getId())
                                ->setUserId($user->getId())
                                ->setRoleId($roleId)
                                ->toArray()
            ]
        ]);
    }

    public function fromArrayExcludedProperties()
    {
        return ['enrollmentmethods', 'filters'];
    }

    /**
     * @param $additionalToArrayExcludedProperties
     * @return array
     */
    public function toArrayExcludedProperties($additionalToArrayExcludedProperties)
    {
        return ['displayname'];
    }

    // Properties Getters & Setters

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdnumber()
    {
        return $this->idnumber;
    }

    /**
     * @param mixed $idnumber
     */
    public function setIdnumber($idnumber)
    {
        $this->idnumber = $idnumber;
        return $this;
    }

    public function getShortName()
    {
        return $this->shortName;
    }

    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
        return $this;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    public function getSummaryFormat()
    {
        return $this->summaryFormat;
    }

    public function setSummaryFormat($summaryFormat)
    {
        $this->summaryFormat = $summaryFormat;
        return $this;
    }

    /**
     * @return File[]
     */
    public function getSummaryFiles()
    {
        return $this->summaryFiles;
    }

    public function setSummaryFiles($summaryFiles)
    {
        $this->summaryFiles = $summaryFiles;
        return $this;
    }

    /**
     * @return File[]
     */
    public function getOverviewFiles()
    {
        return $this->overviewFiles;
    }

    public function setOverviewFiles($overviewFiles)
    {
        $this->overviewFiles = $overviewFiles;
        return $this;
    }
    
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
        return $this;
    }

    /**
     * @return CourseFormatOption[]
     */
    public function getCourseFormatOptions()
    {
        return $this->courseFormatOptions;
    }

    /**
     * @param array $courseFormatOptions
     */
    public function setCourseFormatOptions($courseFormatOptions)
    {
        $this->courseFormatOptions = $courseFormatOptions;
        return $this;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return int
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param int $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
        return $this;
    }

}
