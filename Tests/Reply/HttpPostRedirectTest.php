<?php

namespace Payum\Core\Tests\Reply;

use Payum\Core\Reply\HttpPostRedirect;
use Payum\Core\Reply\HttpResponse;
use Payum\Core\Reply\ReplyInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class HttpPostRedirectTest extends TestCase
{
    public function testShouldImplementReplyInterface()
    {
        $rc = new ReflectionClass(HttpPostRedirect::class);

        $this->assertTrue($rc->implementsInterface(ReplyInterface::class));
    }

    public function testShouldBeSubClassOfHttpPostRedirectReply()
    {
        $rc = new ReflectionClass(HttpPostRedirect::class);

        $this->assertTrue($rc->isSubclassOf(HttpResponse::class));
    }

    public function testShouldAllowGetContentWhenPostNotSet()
    {
        $expectedContent = <<<'HTML'
<!DOCTYPE html>
<html>
    <head>
        <title>Redirecting...</title>
    </head>
    <body onload="document.forms[0].submit();">
        <form action="theUrl" method="post">
            <p>Redirecting to payment page...</p>
            <p></p>
        </form>
    </body>
</html>
HTML;

        $request = new HttpPostRedirect('theUrl');

        $this->assertSame($expectedContent, $request->getContent());
    }

    public function testShouldAllowGetContentWhenPostSet()
    {
        $expectedContent = <<<'HTML'
<!DOCTYPE html>
<html>
    <head>
        <title>Redirecting...</title>
    </head>
    <body onload="document.forms[0].submit();">
        <form action="theUrl" method="post">
            <p>Redirecting to payment page...</p>
            <p><input type="hidden" name="foo" value="fooVal" />
<input type="hidden" name="bar" value="barVal" />
</p>
        </form>
    </body>
</html>
HTML;

        $request = new HttpPostRedirect('theUrl', [
            'foo' => 'fooVal',
            'bar' => 'barVal',
        ]);

        $this->assertSame($expectedContent, $request->getContent());
    }

    public function testShouldEscapeHtmlSpecialChars()
    {
        $expectedContent = <<<'HTML'
<!DOCTYPE html>
<html>
    <head>
        <title>Redirecting...</title>
    </head>
    <body onload="document.forms[0].submit();">
        <form action="theUrl" method="post">
            <p>Redirecting to payment page...</p>
            <p><input type="hidden" name="foo" value="&lt;&gt;&amp;&quot;" />
</p>
        </form>
    </body>
</html>
HTML;

        $request = new HttpPostRedirect('theUrl', [
            'foo' => '<>&"',
        ]);

        $this->assertSame($expectedContent, $request->getContent());
    }

    public function testShouldAllowGetDefaultStatusCodeSetInConstructor()
    {
        $request = new HttpPostRedirect('anUrl');

        $this->assertSame(200, $request->getStatusCode());
    }

    public function testShouldAllowGetCustomStatusCodeSetInConstructor()
    {
        $request = new HttpPostRedirect('anUrl', [], 201);

        $this->assertSame(201, $request->getStatusCode());
    }

    public function testShouldAllowGetDefaultHeadersSetInConstructor()
    {
        $request = new HttpPostRedirect('anUrl');

        $this->assertEquals([], $request->getHeaders());
    }

    public function testShouldAllowGetCustomHeadersSetInConstructor()
    {
        $expectedHeaders = [
            'foo' => 'fooVal',
            'bar' => 'barVal',
        ];

        $request = new HttpPostRedirect('anUrl', [], 200, $expectedHeaders);

        $this->assertEquals($expectedHeaders, $request->getHeaders());
    }
}
