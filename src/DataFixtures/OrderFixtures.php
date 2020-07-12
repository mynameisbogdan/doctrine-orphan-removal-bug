<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $order = new Order();
        $order->setCode('order_code');

        $order->addItem((new OrderItem())->setCode('alpha'));
        $order->addItem((new OrderItem())->setCode('beta'));
        $order->addItem((new OrderItem())->setCode('omega'));

        $manager->persist($order);
        $manager->flush();
    }
}
