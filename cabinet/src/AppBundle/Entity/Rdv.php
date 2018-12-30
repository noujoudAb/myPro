<?php
/**
 * Created by PhpStorm.
 * User: Riadh
 * Date: 12/14/2018
 * Time: 3:47 AM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="rdv")
*/
class Rdv
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id_rdv;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="Rdv")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $id_user;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @return mixed
     */
    public function getIdRdv()
    {
        return $this->id_rdv;
    }

    /**
     * @param mixed $id_rdv
     */
    public function setIdRdv($id_rdv)
    {
        $this->id_rdv = $id_rdv;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


}