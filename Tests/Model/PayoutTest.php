<?php

namespace Payum\Core\Tests\Model;

use Payum\Core\Model\Payout;
use Payum\Core\Model\PayoutInterface;
use PHPUnit\Framework\TestCase;

class PayoutTest extends TestCase
{
    /**
     * @test
     */
    public function shouldExtendPayoutInterface()
    {
        $rc = new \ReflectionClass(Payout::class);

        $this->assertTrue($rc->implementsInterface(PayoutInterface::class));
    }

    /**
     * @test
     */
    public function shouldAllowGetRecipientIdPreviouslySet()
    {
        $payout = new Payout();
        $payout->setRecipientId('theVal');

        $this->assertSame('theVal', $payout->getRecipientId());
    }

    /**
     * @test
     */
    public function shouldAllowGetRecipientEmailPreviouslySet()
    {
        $payout = new Payout();
        $payout->setRecipientEmail('theVal');

        $this->assertSame('theVal', $payout->getRecipientEmail());
    }

    /**
     * @test
     */
    public function shouldAllowGetTotalAmountPreviouslySet()
    {
        $payout = new Payout();
        $payout->setTotalAmount('theVal');

        $this->assertSame('theVal', $payout->getTotalAmount());
    }

    /**
     * @test
     */
    public function shouldAllowGetCurrencyCodePreviouslySet()
    {
        $payout = new Payout();
        $payout->setCurrencyCode('theVal');

        $this->assertSame('theVal', $payout->getCurrencyCode());
    }

    /**
     * @test
     */
    public function shouldAllowGetDescriptionPreviouslySet()
    {
        $payout = new Payout();
        $payout->setDescription('theVal');

        $this->assertSame('theVal', $payout->getDescription());
    }

    /**
     * @test
     */
    public function shouldAllowGetDetailsPreviouslySet()
    {
        $payout = new Payout();

        $payout->setDetails(['foo' => 'fooVal']);

        $this->assertEquals(['foo' => 'fooVal'], $payout->getDetails());
    }
}
