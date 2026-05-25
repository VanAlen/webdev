<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create Admin User (VERIFIED - no email verification needed)
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admingemz@gmail.com');  // ✅ ADD EMAIL
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsVerified(true);  // ✅ ALREADY VERIFIED
        $admin->setVerificationToken(null);  // ✅ NO TOKEN NEEDED
        $admin->setStatus('active');  // ✅ ACTIVE STATUS
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin123');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        // Create Staff User (VERIFIED)
        $staff = new User();
        $staff->setUsername('staff');
        $staff->setEmail('staffgemz@gmail.com');  // ✅ ADD EMAIL
        $staff->setRoles(['ROLE_STAFF']);
        $staff->setIsVerified(true);  // ✅ ALREADY VERIFIED
        $staff->setVerificationToken(null);  // ✅ NO TOKEN NEEDED
        $staff->setStatus('active');  // ✅ ACTIVE STATUS
        $hashedPassword = $this->passwordHasher->hashPassword($staff, 'staff123');
        $staff->setPassword($hashedPassword);
        $manager->persist($staff);

        // Create Regular User (FIXED - give it a token since NOT verified)
        $user = new User();
        $user->setUsername('user');
        $user->setEmail('sniggurath8@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setIsVerified(false);  // ❌ NOT verified
        $user->setVerificationToken(bin2hex(random_bytes(32)));  // ✅ MUST have a token!
        $user->setStatus('pending');  // ✅ Better to set 'pending' status
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'user123');
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}