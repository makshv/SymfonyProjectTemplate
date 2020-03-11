<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Finder\Finder;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    private $encoder;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Test API');
        $user->setLastName('Test API');
        $user->setEmail('test0@test.com');
        $user->setUsername('test0@test.com');
        $user->setPlainPassword('test00000');
        $user->setRoles(['ROLE_API']);
        $user->setPassword($this->encoder->encodePassword($user, $user->getPlainPassword()));
        $user->setUsernameCanonical('test0@test.com');
        $user->setEmailCanonical('test0@test.com');
        $user->setEnabled(true);
        $manager->persist($user);

        // ........

        //Run SQL
        $finder = new Finder();
        $finder->in(__DIR__.'/SQL');
        $finder->name('initial_dev_data.sql');

        foreach ($finder as $file) {
            $content = $file->getContents();
            $this->container->get('doctrine.orm.entity_manager')->getConnection()->exec($content);
            $this->container->get('doctrine.orm.entity_manager')->flush();
        }

        $manager->flush();
    }

    /**
     * @param $time string
     *
     * @return \DateTime
     *
     * @throws \Exception
     */
    public function _time($time)
    {
        return new \DateTime($time);
    }

}
