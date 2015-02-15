<?php

namespace W4f\GameBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use W4f\GameBundle\Action\ActionConstants;
use W4f\GameBundle\Model\Account;

class LoadAccountData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
    	$firstUser = new Account();
    	$firstUser->setLogin('user1');
    	$firstUser->setEmail('user1@mail.com');
    	$firstUser->setPassword(password_hash('password', PASSWORD_BCRYPT, array('salt'=>ActionConstants::$userBcryptSalt)));
        
        $manager->persist($firstUser);
        $manager->flush();
    }
}