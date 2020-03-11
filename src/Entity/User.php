<?php
/**
 * User.php.
 *
 * User Entity
 *
 * @category   Entity
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;

/**
 * User.
 *
 * @ORM\Table(name="services_admin.user",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(columns={"username"}),
 *          @ORM\UniqueConstraint(columns={"email"})
 *      });
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository");
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User extends BaseUser implements UserInterface, TwoFactorInterface
{
    use TimestampableTrait;

    public const DEFAULT_ROLE = 'ROLE_CLIENT';

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=150)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $plainApiToken;

    /**
     * @var string
     *
     * @ORM\Column(name="api_token", type="string", length=255, nullable=true)
     */
    protected $apiToken;

    /**
     * @ORM\Column(name="settings", type="json")
     */
    protected $settings;

    /**
     * @ORM\Column(name="googleAuthenticatorSecret", type="string", nullable=true)
     */
    private $googleAuthenticatorSecret;

    public function __construct()
    {
        parent::__construct();
        $this->settings = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): User
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getPlainApiToken(): ?string
    {
        return $this->plainApiToken;
    }

    public function setPlainApiToken(?string $plainApiToken): User
    {
        $this->plainApiToken = $plainApiToken;

        return $this;
    }

    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }

    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getSettings(): array
    {
        return $this->settings ? $this->settings : [];
    }

    public function setSettings($settings): User
    {
        $this->settings = $settings;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return $this->googleAuthenticatorSecret ? true : false;
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        return $this->username;
    }

    public function getGoogleAuthenticatorSecret(): ?string
    {
        return $this->googleAuthenticatorSecret;
    }

    public function setGoogleAuthenticatorSecret(?string $googleAuthenticatorSecret): void
    {
        $this->googleAuthenticatorSecret = $googleAuthenticatorSecret;
    }
}
