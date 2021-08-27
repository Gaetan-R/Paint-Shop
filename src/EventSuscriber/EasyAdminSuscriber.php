<?php
 namespace App\EventSuscriber;

 use App\Entity\Blogpost;
 use App\Entity\Commentaire;
 use App\Entity\Peinture;
 use DateTime;
 use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
 use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 use Symfony\Component\Security\Core\Security;
 use Symfony\Component\String\Slugger\SluggerInterface;


 class EasyAdminSuscriber implements EventSubscriberInterface
 {
     private $slugger;
     private $user;

     public function __construct(SluggerInterface $slugger, Security $security)
     {
         $this->slugger = $slugger;
         $this->security = $security;
     }

     public static function  getSubscribedEvents()
     {
            return [
                BeforeEntityPersistedEvent::class => ['setDateAndUser'],
            ];
     }

     public function setDateAndUser(BeforeEntityPersistedEvent $event)
     {
         $entity = $event->getEntityInstance();

         if (!($entity instanceof Blogpost)) {

             $now = new DateTime('now');
             $entity->setCreatedAt($now);

             $user = $this->security->getUser();
             $entity->getUser($user);
         }

         if (!($entity instanceof Peinture)) {

             $now = new DateTime('now');
             $entity->setCreatedAt($now);

             $user = $this->security->getUser();
             $entity->getUser($user);
         }

         if (!($entity instanceof  Commentaire)) {

             $now = new DateTime('now');
             $entity->setCreatedAt($now);

             $user = $this->security->getUser();
             $entity->getUser($user);
         }


     }

 }