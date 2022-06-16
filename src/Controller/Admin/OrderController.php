<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Mailjet\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OrderController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;
    private AdminUrlGenerator $urlGenerator;

    public function __construct(
        EntityManagerInterface $entityManager,
        AdminUrlGenerator $urlGenerator
    )
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Préparer la commande', 'fa fa-cogs')->linkToCrudAction('updatePreparation');
        $updateDelivery = Action::new('updateDelivery', 'Livrer la commande', 'fas fa-box-open')->linkToCrudAction('updateDelivery');

        return $actions
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->add('index', 'detail')
        ;
    }

    public function updatePreparation(AdminContext $context): RedirectResponse
    {
        $order = $context->getEntity()->getInstance();
        $order->setStatus(2);

        $this->entityManager->flush();

        $this->addFlash('success', 'La commande ' . $order->getReference() . ' est en cours de préparation.');

        $mailer = new Mailer();
        $mailer->send(
            $order->getUser()->getEmail(),
            $order->getUser()->getLastName(),
            "Commande {$order->getReference()} en cours de préparation",
            'Bonne nouvelle !',
            "Votre commande {$order->getReference()} est est en cours de préparation.<br />Elle sera bientôt prête à être liverer."
        );

        $url = $this->urlGenerator
            ->setController(OrderController::class)
            ->setAction('index')
            ->generateUrl()
        ;

        return $this->redirect($url);
    }

    public function updateDelivery(AdminContext $context): RedirectResponse
    {
        $order = $context->getEntity()->getInstance();
        $order->setStatus(3);

        $this->entityManager->flush();

        $this->addFlash('success', 'La commande ' . $order->getReference() . ' est en cours de livraison.');

        $mailer = new Mailer();
        $mailer->send(
            $order->getUser()->getEmail(),
            $order->getUser()->getLastName(),
            "Commande {$order->getReference()} en cours de livraison",
            'Vous recevrez bientôt votre commande !',
            "Votre commande {$order->getReference()} est en cours de livraison.<br />Elle sera bientôt chez vous."
        );

        $url = $this->urlGenerator
            ->setController(OrderController::class)
            ->setAction('index')
            ->generateUrl()
        ;

        return $this->redirect($url);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('user.getFullName', 'Client'),
            TextEditorField::new('delivery', 'Adresse de livraison')->onlyOnDetail(),
            DateTimeField::new('createdAt', 'Commande passée le'),
            ArrayField::new('orderDetails', 'Produit')->hideOnIndex(),
            TextField::new('carrierName', 'Transporteur')->hideOnIndex(),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR')->hideOnIndex(),
            MoneyField::new('total')->setCurrency('EUR'),
            ChoiceField::new('status', 'Statut')->setChoices([
                'Non payée' => 0,
                'Payée' => 1,
                'Préparation en cours' => 2,
                'Livraison en cours' => 3
            ])
        ];
    }
}
