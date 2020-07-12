<?php

namespace App\Command;

use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DoctrineOrphanRemovalCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'app:doctrine-orphan-removal';

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $stack = new DebugStack();
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger($stack);

        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['code' => 'order_code']);

        $itemToRemove = $order->getItems()
            ->filter(function (OrderItem $item) {
                return $item->getCode() === 'omega';
            })
            ->first()
        ;
        $order->removeItem($itemToRemove);

        $itemToAdd = new OrderItem();
        $itemToAdd->setCode(sprintf('rand_%d', random_int(0, PHP_INT_MAX)));
        $order->addItem($itemToAdd);

        $itemToAdd = new OrderItem();
        $itemToAdd->setCode('omega');
        $order->addItem($itemToAdd);

        $this->entityManager->flush();

        dump($stack->queries);

        $io->success('All good');

        return 0;
    }
}
