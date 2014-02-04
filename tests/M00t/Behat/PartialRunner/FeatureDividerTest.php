<?php

namespace M00t\Behat\PartialRunner;

class FeatureDividerTest extends \PHPUnit_Framework_TestCase {

    public function testOneWorker()
    {
        $divider = new FeatureDivider(array('feature1', 'feature2'));
        $divider->setPartsCount(1);

        $this->assertEquals(array('feature1', 'feature2'), $divider->getFeaturesForPart(0));
    }

    public function testErrorIfUndefinedPartsCount()
    {
        $divider = new FeatureDivider(array('feature1', 'feature2'));

        $this->setExpectedException('M00t\Behat\PartialRunner\Exception');
        $divider->getFeaturesForPart(0);
    }

    public function testErrorIfCountPartsLessThanRequestedPart()
    {
        $divider = new FeatureDivider(array('feature1', 'feature2'));
        $divider->setPartsCount(10);

        $this->setExpectedException('M00t\Behat\PartialRunner\Exception');
        $divider->getFeaturesForPart(10);
    }

    public function testGetFeaturesForPartSimple()
    {
        $divider = new FeatureDivider(array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10'));
        $divider->setPartsCount(10);

        $this->assertEquals(array('1'), $divider->getFeaturesForPart(0));
        $this->assertEquals(array('2'), $divider->getFeaturesForPart(1));
        $this->assertEquals(array('3'), $divider->getFeaturesForPart(2));
        $this->assertEquals(array('4'), $divider->getFeaturesForPart(3));
        $this->assertEquals(array('5'), $divider->getFeaturesForPart(4));
        $this->assertEquals(array('6'), $divider->getFeaturesForPart(5));
        $this->assertEquals(array('7'), $divider->getFeaturesForPart(6));
        $this->assertEquals(array('8'), $divider->getFeaturesForPart(7));
        $this->assertEquals(array('9'), $divider->getFeaturesForPart(8));
        $this->assertEquals(array('10'), $divider->getFeaturesForPart(9));
    }

    public function testGetFeaturesMod()
    {
        $divider = new FeatureDivider(array('1', '2', '3', '4', '5'));
        $divider->setPartsCount(2);

        $this->assertEquals(array('1', '2', '3'), $divider->getFeaturesForPart(0));
        $this->assertEquals(array('4', '5'), $divider->getFeaturesForPart(1));
    }

    public function testGetFeatureMoreComplex()
    {
        $divider = new FeatureDivider(array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10'));
        $divider->setPartsCount(4);

        $this->assertEquals(array('1', '2', '3'), $divider->getFeaturesForPart(0));
        $this->assertEquals(array('4', '5', '6'), $divider->getFeaturesForPart(1));
        $this->assertEquals(array('7', '8'), $divider->getFeaturesForPart(2));
        $this->assertEquals(array('9', '10'), $divider->getFeaturesForPart(3));
    }

    public function testGetFeatureFiveAndFore()
    {
        $divider = new FeatureDivider(array('1', '2', '3', '4', '5'));
        $divider->setPartsCount(4);

        $this->assertEquals(array('1', '2'), $divider->getFeaturesForPart(0));
        $this->assertEquals(array('3'), $divider->getFeaturesForPart(1));
        $this->assertEquals(array('4'), $divider->getFeaturesForPart(2));
        $this->assertEquals(array('5'), $divider->getFeaturesForPart(3));
    }

}