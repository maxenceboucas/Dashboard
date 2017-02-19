<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\TagRepository")
 */
class Tag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
    * Many Tags have Many Contacts.
    * @ORM\ManyToMany(targetEntity="Contact", mappedBy="tags")
    */
    private $contacts;

    public function __construct() {
    }

    public function __toString() {
        return $this->getName();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = mb_strtolower($name, 'UTF-8');

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add contact
     *
     * @param \DashboardBundle\Entity\Contact $contact
     *
     * @return Tag
     */
    public function addContact(\DashboardBundle\Entity\Contact $contact)
    {
      if (!$this->contacts->contains($contact)) {
          $this->contacts->add($contact);
      }
    }

    /**
     * Remove contact
     *
     * @param \DashboardBundle\Entity\Contact $contact
     */
    public function removeContact(\DashboardBundle\Entity\Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}
