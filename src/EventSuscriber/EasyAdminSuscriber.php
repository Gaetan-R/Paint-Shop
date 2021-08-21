<?php
 namespace App\EventSuscriber;

 use App\Entity\Blogpost;
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
                BeforeEntityPersistedEvent::class => ['setBlogPostSlugAndDate'],
            ];
     }

     public function setBLogPostSlugAndDate(BeforeEntityPersistedEvent $event)
     {
         $entity =$event->getEntityInstance();

         if (!($entity instanceof Blogpost)) {
             return;
         }

         $slug = $this->slugger->slug($entity->getTitre());
         $entity->setSlug($slug);

         $now = new DateTime('now');
         $entity->setCreatedAt($now);

         $user = $this->security->getUser();
         $entity->setUser($user);
     }


 }