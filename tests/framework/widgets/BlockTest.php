<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yiiunit\framework\widgets;

use yii\widgets\Block;

/**
 * @group widgets
 */
class BlockTest extends \yiiunit\TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->mockWebApplication();
    }

    /**
     * @see https://github.com/yiisoft/yii2/issues/15536
     */
    public function testShouldTriggerInitEvent()
    {
        $initTriggered = false;

        $block = new Block(
            [
                'on init' => function () use (&$initTriggered) {
                    $initTriggered = true;
                }
            ]
        );

        ob_get_clean();

        $this->assertTrue($initTriggered);
    }

    public function testAfterRunResultNotEmpty()
    {
        $result = null;

        ob_start();
        Block::begin([
            'renderInPlace' => true,
            'on afterRun' => function($event) use (&$result) {
                $result = $event->result;
            },
        ]);

        echo 'The Block';

        Block::end();
        ob_end_clean();

        $this->assertEquals('The Block', $result);
    }
}
