<?php
namespace Sopinet\ChatBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use JMS\Serializer\Annotation\Groups;

use Doctrine\ORM\Event\OnFlushEventArgs;

/**
* @ORM\Entity(repositoryClass="Sopinet\ChatBundle\Entity\DeviceRepository")
* @ORM\Table(name="sopinet_chatbundle_device")
* @DoctrineAssert\UniqueEntity("deviceId")
*/
class Device
{
    use ORMBehaviors\Timestampable\Timestampable;

    const TYPE_IOS="iOS";
    const TYPE_ANDROID="Android";

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="NONE")
     * @Groups({"create"})
     *
     * DeviceToken from Device
     *
     */
    protected $deviceId;

    /**
     * @var string
     *
     * @ORM\Column(name="deviceGCMId", type="string", nullable=true)
     * @Groups({"create"})
     *
     */
    protected $deviceGCMId;

    /**
     * @ORM\ManyToMany(targetEntity="\Application\Sonata\UserBundle\Entity\User", inversedBy="devices")
     * @ORM\JoinTable(name="sopinet_chatbundle_users_devices")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="fromDevice")
     * @ORM\JoinColumn(name="message_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $messages;

    /**
     * @ORM\OneToMany(targetEntity="MessagePackage", mappedBy="toDevice")
     * @ORM\JoinColumn(name="messagePackageReceived_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $messagesPackageReceived;

    /**
     * @var string
     * iOS
     * Android
     * @ORM\Column(name="type", type="string", columnDefinition="enum('iOS','Android')")
     */
    protected $deviceType;

    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    /**
     * Get deviceId
     *
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    public function setDeviceGCMId($deviceGCMId)
    {
        $this->deviceGCMId = $deviceGCMId;
    }

    public function getDeviceGCMId()
    {
        return $this->deviceGCMId;
    }

    /**
     * Set deviceType
     *
     * @param string $deviceType
     *
     * @return Device
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * Get deviceType
     *
     * @return string
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    public function __toString() {
        return $this->getDeviceId();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Device
     */
    public function addUser(\Application\Sonata\UserBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     */
    public function removeUser(\Application\Sonata\UserBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add message
     *
     * @param Message $message
     *
     * @return Device
     */
    public function addMessage(Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param Message $message
     */
    public function removeMessage(MessagePackage $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add message
     *
     * @param MessagePackage $messagePackageReceived
     *
     * @return User
     */
    public function addMessagePackageReceived(MessagePackage $messagePackageReceived)
    {
        $this->messagesPackageReceived[] = $messagePackageReceived;

        return $this;
    }

    /**
     * Remove message
     *
     * @param MessagePackage $messagePackageReceived
     */
    public function removeMessagePackageReceived(MessagePackage $messagePackageReceived)
    {
        $this->messagesPackageReceived->removeElement($messagePackageReceived);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessagesPackageReceived()
    {
        return $this->messagesPackageReceived;
    }

    /**
     * Add messagesPackageReceived
     *
     * @param \Sopinet\ChatBundle\Entity\MessagePackage $messagesPackageReceived
     * @return Device
     */
    public function addMessagesPackageReceived(\Sopinet\ChatBundle\Entity\MessagePackage $messagesPackageReceived)
    {
        $this->messagesPackageReceived[] = $messagesPackageReceived;

        return $this;
    }

    /**
     * Remove messagesPackageReceived
     *
     * @param \Sopinet\ChatBundle\Entity\MessagePackage $messagesPackageReceived
     */
    public function removeMessagesPackageReceived(\Sopinet\ChatBundle\Entity\MessagePackage $messagesPackageReceived)
    {
        $this->messagesPackageReceived->removeElement($messagesPackageReceived);
    }
}