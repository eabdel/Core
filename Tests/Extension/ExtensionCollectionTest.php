<?php
namespace Payum\Core\Tests\Extension;

use Payum\Core\Extension\Context;
use Payum\Core\Extension\ExtensionCollection;
use Payum\Core\Extension\ExtensionInterface;
use Payum\Core\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ExtensionCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function shouldImplementExtensionInterface(): void
    {
        $rc = new \ReflectionClass('Payum\Core\Extension\ExtensionCollection');

        $this->assertTrue($rc->implementsInterface('Payum\Core\Extension\ExtensionInterface'));
    }

    /**
     * @test
     */
    public function shouldAllowAddExtensionAppendByDefault(): void
    {
        $extensionFirst = $this->createExtensionMock();
        $extensionSecond = $this->createExtensionMock();

        $collection = new ExtensionCollection();

        $collection->addExtension($extensionFirst);
        $collection->addExtension($extensionSecond);

        $addedExtensions = $this->readAttribute($collection, 'extensions');

        $this->assertIsArray($addedExtensions);
        $this->assertCount(2, $addedExtensions);

        $this->assertSame($extensionFirst, $addedExtensions[0]);
        $this->assertSame($extensionSecond, $addedExtensions[1]);
    }

    /**
     * @test
     */
    public function shouldAllowAddExtensionWithForcedPrepend(): void
    {
        $extensionFirst = $this->createExtensionMock();
        $extensionSecond = $this->createExtensionMock();

        $collection = new ExtensionCollection();

        $collection->addExtension($extensionFirst);
        $collection->addExtension($extensionSecond, $forcePrepend = true);

        $addedExtensions = $this->readAttribute($collection, 'extensions');

        $this->assertIsArray($addedExtensions);
        $this->assertCount(2, $addedExtensions);

        $this->assertSame($extensionSecond, $addedExtensions[0]);
        $this->assertSame($extensionFirst, $addedExtensions[1]);
    }

    /**
     * @test
     */
    public function shouldCallOnPreExecuteForAllExtensionsInCollection(): void
    {
        $expectedContext = $this->createContextMock();

        $extensionFirst = $this->createExtensionMock();
        $extensionFirst
            ->expects($this->once())
            ->method('onPreExecute')
            ->with($this->identicalTo($expectedContext))
        ;

        $extensionSecond = $this->createExtensionMock();
        $extensionSecond
            ->expects($this->once())
            ->method('onPreExecute')
            ->with($this->identicalTo($expectedContext))
        ;

        $collection = new ExtensionCollection();
        $collection->addExtension($extensionFirst);
        $collection->addExtension($extensionSecond);

        $result = $collection->onPreExecute($expectedContext);

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function shouldCallOnExecuteForAllExtensionsInCollection(): void
    {
        $expectedContext = $this->createContextMock();

        $extensionFirst = $this->createExtensionMock();
        $extensionFirst
            ->expects($this->once())
            ->method('onExecute')
            ->with($this->identicalTo($expectedContext))
        ;

        $extensionSecond = $this->createExtensionMock();
        $extensionSecond
            ->expects($this->once())
            ->method('onExecute')
            ->with($expectedContext)
        ;

        $collection = new ExtensionCollection();
        $collection->addExtension($extensionFirst);
        $collection->addExtension($extensionSecond);

        $result = $collection->onExecute($expectedContext);

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function shouldCallOnPostExecuteForAllExtensionsInCollection(): void
    {
        $expectedContext = $this->createContextMock();

        $extensionFirst = $this->createExtensionMock();
        $extensionFirst
            ->expects($this->once())
            ->method('onPostExecute')
            ->with($this->identicalTo($expectedContext))
        ;

        $extensionSecond = $this->createExtensionMock();
        $extensionSecond
            ->expects($this->once())
            ->method('onPostExecute')
            ->with($expectedContext)
        ;

        $collection = new ExtensionCollection();
        $collection->addExtension($extensionFirst);
        $collection->addExtension($extensionSecond);

        $result = $collection->onPostExecute($expectedContext);

        $this->assertNull($result);
    }

    protected function createContextMock(): Context|MockObject
    {
        return $this->createMock('Payum\Core\Extension\Context');
    }

    protected function createExtensionMock(): ExtensionInterface|MockObject
    {
        return $this->createMock('Payum\Core\Extension\ExtensionInterface');
    }
}
