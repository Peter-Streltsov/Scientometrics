<?php

namespace app\models\pnrd;

// project classes
use app\models\identity\Authors;
use app\models\identity\Personnel;
use app\models\identity\Users;
// yii classes
use Yii;
use yii\base\Model;

/**
 * Class PersonalData
 * Provides PNRD data for current user or requested user (if is set $id parameter in constructor);
 *
 * @package app\models\pnrd
 */
class PersonalData extends Model
{

    /**
     * @var Users $user
     */
    public $user; // user data

    /**
     * staff data for employee of current authorized user;
     *
     * @var Personnel $employee
     */
    public $employee;

    /**
     * author's data for author of current authorized user;
     *
     * @var Authors
     */
    public $author;


    /**
     * PersonalData constructor;
     *
     * @param Users|null $user
     */
    public function __construct(Users $user = null)
    {
        parent::__construct();
        $this->initIdentityModels($user);
    } // end construct


    /**
     * sets private properties $user, $employee and $author
     * @param Users $user
     */
    private function initIdentityModels(Users $user)
    {
        // if $user parameter is null - fills $user property with current identity model
        $user != null ? $this->user = $user : $this->user = Yii::$app->user->getIdentity();
        $this->employee = $this->user->getStaff();
        $this->author = $this->user->getAuthor();
    } // end function


    /******************************************************************************************************************/
    /** GETTERS *******************************************************************************************************/

    /**
     * return current identity ArticlesJournals;
     *
     * @return mixed
     */
    public function getArticlesJournals()
    {
        return $this->author->articlesJournals;
    } // end function


    /**
     * return current identity ArticlesConferences;
     *
     * @return mixed
     */
    public function getArticlesConferences()
    {
        return $this->author->articlesConferences;
    } // end function


    /**
     * return current identity ArticlesCollections;
     *
     * @return mixed
     */
    public function getArticlesCollections()
    {
        return $this->author->articlesCollections;
    } // end function


    /**
     * returns current identity Monographs;
     *
     * @return mixed
     */
    public function getMonographs()
    {
        return $this->author->monographs;
    } // end function


    /**
     * returns current identity Dissertations;
     *
     * @return mixed
     */
    public function getDissertations()
    {
        return $this->author->dissertations;
    } // end function


    /**
     * Returns array aof all publications for current identity/Authors model;
     *
     * @return array
     */
    public function getPublications()
    {
        return [
            $this->author->articlesJournals,
            $this->author->articlesConferences,
            $this->author->articlesCollections,
            $this->author->monographs,
            $this->author->dissertations
        ];
    } // end function


    /**
     * calculates total index for current user model;
     *
     * @return float
     */
    public function getIndex()
    {
        // if something went wrong with identity models will return 0
        /*if ($this->user == null && $this->author == null) {
            return 0;
        }*/

        // resulting array
        $index = [];
        //echo count($this->author->indexedArticlesJournals);

        // calculating indexes for ArticlesJournals
        foreach ($this->author->indexedArticlesJournals as $article) {
            $index[] = $article->getIndexByAuthor($this->author->id);
        }

        // calculating indexes for ArticlesConferences
        foreach ($this->author->indexedArticlesConferences as $article) {
            $index[] = $article->getIndexByAuthor($this->author->id);
        }

        foreach ($this->author->indexedArticlesCollections as $article) {
            $index[] = $article->getIndexByAuthor($this->author->id);
        }

        // calculating indexes for Monographs
        /*foreach ($this->author->indexedMonographs as $monograph) {
            $index[] = $monograph->getIndexByAuthor($this->author->id);
        }*/

        // calculating indexes for Dissertations
        foreach ($this->author->indexedDissertations as $dissertation) {
            $index[] = $dissertation->getIndexByAuthor($this->author->id);
        }

        return (float)array_sum($index);
    } // end function


    /** END GETTERS ***************************************************************************************************/
    /******************************************************************************************************************/



    /******************************************************************************************************************/
    /** COUNTERS ******************************************************************************************************/

    /**
     * @return float
     */
    public function countArticlesJournals()
    {
        return (float)count($this->author->articlesJournals);
    } // end function


    /**
     * @return float
     */
    public function countArticlesConferences()
    {
        return (float)count($this->author->articlesConferences);
    } // end function


    /**
     * @return float
     */
    public function countArticlesCollections()
    {
        return (float)count($this->author->articlesCollections);
    } // end function


    /**
     * @return float
     */
    public function countMonographs()
    {
        return (float)count($this->author->monographs);
    } // end function


    /**
     * @return float
     */
    public function countDissertations()
    {
        return (float)count($this->author->dissertations);
    } // end function


    /** END COUNTERS **************************************************************************************************/
    /******************************************************************************************************************/


    /**
     * Calculates median index for all registered users;
     *
     * @return float
     */
    public function getMedianIndex()
    {
        $index = 0;
        $count = 0;
        $users = Users::find()->all();
        foreach ($users as $user) {
            $author = $user->getAuthor();
            if ($author != null) {
                $personal = new PersonalData($user);
                $index += $personal->getIndex();
                $count++;
            }
        }
        return $index / $count;
    } // end function

} // end class
