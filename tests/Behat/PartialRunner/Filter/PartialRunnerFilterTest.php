<?php namespace Tests\Behat\ParallelRunner\Filter;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\OutlineNode;
use Behat\Gherkin\Node\ScenarioNode;
use Exception;
use InvalidArgumentException;
use Behat\PartialRunner\Filter\PartialRunnerFilter;

class ParallelWorkerFilterTest extends FilterTest
{
    /**
     * This test is for making sure that invalid arguments for construction properly except.
     */
    public function testParallelWorkerFilter()
    {
        // message check
        try {
            new PartialRunnerFilter(10, -10);
            $this->expectException(InvalidArgumentException::class);
        } catch (Exception $e) {
            $this->assertEquals('Received bad arguments for ($countWorkers, $workerNumber): (10, -10).', $e->getMessage());
        }

        /***************************
         *   Invalid Arguments    *
         **************************/
        try {
            new PartialRunnerFilter(1, -1);
            $this->expectException(InvalidArgumentException::class);
        } catch (Exception $e) {
            $this->assertTrue($e instanceof InvalidArgumentException);
        }

        try {
            new PartialRunnerFilter(0, 0);
            $this->expectException(InvalidArgumentException::class);
        } catch (Exception $e) {
            $this->assertTrue($e instanceof InvalidArgumentException);
        }

        try {
            new PartialRunnerFilter(-1, -1);
            $this->expectException(InvalidArgumentException::class);
        } catch (Exception $e) {
            $this->assertTrue($e instanceof InvalidArgumentException);
        }

        try {
            new PartialRunnerFilter(1, 2);
            $this->expectException(InvalidArgumentException::class);
        } catch (Exception $e) {
            $this->assertTrue($e instanceof InvalidArgumentException);
        }
    }

    /**
     * This test makes sure that isFeatureMatch is always false, regardless of the construct arguments on the filter.
     */
    public function testIsFeatureMatch()
    {
        $feature = new FeatureNode(null, null, [], null, [], null, null, null, 1);

        $filter = new PartialRunnerFilter();
        $this->assertFalse($filter->isFeatureMatch($feature));

        $filter = new PartialRunnerFilter(2, 1);
        $this->assertFalse($filter->isFeatureMatch($feature));

        $filter = new PartialRunnerFilter(5, 2);
        $this->assertFalse($filter->isFeatureMatch($feature));
    }

    /**
     * This test makes sure that isScenarioMatch is always true, regardless of the construct arguments on the filter.
     */
    public function testIsScenarioMatch()
    {
        $scenario = new ScenarioNode(null, [], [], null, 2);

        $filter = new PartialRunnerFilter();
        $this->assertTrue($filter->isScenarioMatch($scenario));

        $filter = new PartialRunnerFilter(2, 1);
        $this->assertTrue($filter->isScenarioMatch($scenario));

        $filter = new PartialRunnerFilter(5, 2);
        $this->assertTrue($filter->isScenarioMatch($scenario));
    }

    /**
     * This tests that FeatureFilter works correctly with the default construction arguments for the filter.
     */
    public function testFeatureFilterDefaults()
    {
        $filter = new PartialRunnerFilter();
        $feature = $filter->filterFeature($this->getParsedFeature());
        $scenarios = $feature->getScenarios();

        $this->assertEquals(count($scenarios), 4);
        $this->assertEquals('Scenario#1', $scenarios[0]->getTitle());
        $this->assertEquals('Scenario#2', $scenarios[1]->getTitle());
        $this->assertEquals('Scenario#3', $scenarios[2]->getTitle());

        $this->assertTrue($scenarios[2] instanceof OutlineNode);
        $this->assertTrue($scenarios[2]->hasExamples());
        $this->assertEquals([
            ['action' => 'act#1', 'outcome' => 'out#1'],
            ['action' => 'act#2', 'outcome' => 'out#2'],
            ['action' => 'act#3', 'outcome' => 'out#3'],
        ], $scenarios[2]->getExampleTable()->getColumnsHash());

        $this->assertEquals('Scenario#4', $scenarios[3]->getTitle());
    }

    /**
     * This tests that FeatureFilter works properly when there are 2 test nodes.
     */
    public function testFeatureFilterNodes2()
    {
        /*****************
         *    Node 1    *
         ****************/
        $filter = new PartialRunnerFilter(2, 0);
        $feature = $filter->filterFeature($this->getParsedFeature());
        $scenarios = $feature->getScenarios();

        $this->assertEquals(count($scenarios), 2);
        $this->assertEquals('Scenario#1', $scenarios[0]->getTitle());
        $this->assertEquals('Scenario#3', $scenarios[1]->getTitle());

        $this->assertTrue($scenarios[1] instanceof OutlineNode);
        $this->assertTrue($scenarios[1]->hasExamples());
        $this->assertEquals([
            ['action' => 'act#1', 'outcome' => 'out#1'],
            ['action' => 'act#3', 'outcome' => 'out#3'],
        ], $scenarios[1]->getExampleTable()->getColumnsHash());

        /*****************
         *    Node 2    *
         ****************/
        $filter = new PartialRunnerFilter(2, 1);
        $feature = $filter->filterFeature($this->getParsedFeature());
        $scenarios = $feature->getScenarios();

        $this->assertEquals(count($scenarios), 3);
        $this->assertEquals('Scenario#2', $scenarios[0]->getTitle());
        $this->assertEquals('Scenario#3', $scenarios[1]->getTitle());

        $this->assertTrue($scenarios[1] instanceof OutlineNode);
        $this->assertTrue($scenarios[1]->hasExamples());
        $this->assertEquals([
            ['action' => 'act#2', 'outcome' => 'out#2'],
        ], $scenarios[1]->getExampleTable()->getColumnsHash());

        $this->assertEquals('Scenario#4', $scenarios[2]->getTitle());
    }

    /**
     * This tests if FeatureFilter works properly when there are 3 test nodes.
     */
    public function testFeatureFilterNodes3()
    {
        /*****************
         *    Node 1    *
         ****************/
        $filter = new PartialRunnerFilter(3, 0);
        $feature = $filter->filterFeature($this->getParsedFeature());
        $scenarios = $feature->getScenarios();

        $this->assertEquals(count($scenarios), 2);
        $this->assertEquals('Scenario#1', $scenarios[0]->getTitle());
        $this->assertEquals('Scenario#3', $scenarios[1]->getTitle());

        $this->assertTrue($scenarios[1] instanceof OutlineNode);
        $this->assertTrue($scenarios[1]->hasExamples());
        $this->assertEquals([
            ['action' => 'act#2', 'outcome' => 'out#2'],
        ], $scenarios[1]->getExampleTable()->getColumnsHash());

        /*****************
         *    Node 2    *
         ****************/
        $filter = new PartialRunnerFilter(3, 1);
        $feature = $filter->filterFeature($this->getParsedFeature());
        $scenarios = $feature->getScenarios();

        $this->assertEquals(count($scenarios), 2);
        $this->assertEquals('Scenario#2', $scenarios[0]->getTitle());
        $this->assertEquals('Scenario#3', $scenarios[1]->getTitle());

        $this->assertTrue($scenarios[1] instanceof OutlineNode);
        $this->assertTrue($scenarios[1]->hasExamples());
        $this->assertEquals([
            ['action' => 'act#3', 'outcome' => 'out#3'],
        ], $scenarios[1]->getExampleTable()->getColumnsHash());

        /*****************
         *    Node 3    *
         ****************/
        $filter = new PartialRunnerFilter(3, 2);
        $feature = $filter->filterFeature($this->getParsedFeature());
        $scenarios = $feature->getScenarios();

        $this->assertEquals(count($scenarios), 2);
        $this->assertEquals('Scenario#3', $scenarios[0]->getTitle());

        $this->assertTrue($scenarios[0] instanceof OutlineNode);
        $this->assertTrue($scenarios[0]->hasExamples());
        $this->assertEquals([
            ['action' => 'act#1', 'outcome' => 'out#1'],
        ], $scenarios[0]->getExampleTable()->getColumnsHash());

        $this->assertEquals('Scenario#4', $scenarios[1]->getTitle());
    }

    /**
     * This tests if FeatureFilter works properly when there are 4 test nodes.
     */
    public function testFeatureFilterNodes4()
    {
        /*****************
         *    Node 1    *
         ****************/
        $filter = new PartialRunnerFilter(4, 0);
        $feature = $filter->filterFeature($this->getParsedFeature());
        $scenarios = $feature->getScenarios();

        $this->assertEquals(count($scenarios), 2);
        $this->assertEquals('Scenario#1', $scenarios[0]->getTitle());
        $this->assertEquals('Scenario#3', $scenarios[1]->getTitle());

        $this->assertTrue($scenarios[1] instanceof OutlineNode);
        $this->assertTrue($scenarios[1]->hasExamples());
        $this->assertEquals([
            ['action' => 'act#3', 'outcome' => 'out#3'],
        ], $scenarios[1]->getExampleTable()->getColumnsHash());

        /*****************
         *    Node 2   *
         ****************/
        $filter = new PartialRunnerFilter(4, 1);
        $feature = $filter->filterFeature($this->getParsedFeature());
        $scenarios = $feature->getScenarios();

        $this->assertEquals(count($scenarios), 2);
        $this->assertEquals('Scenario#2', $scenarios[0]->getTitle());
        $this->assertEquals('Scenario#4', $scenarios[1]->getTitle());

        /*****************
         *    Node 3    *
         ****************/
        $filter = new PartialRunnerFilter(4, 2);
        $feature = $filter->filterFeature($this->getParsedFeature());
        $scenarios = $feature->getScenarios();

        $this->assertEquals(count($scenarios), 1);
        $this->assertEquals('Scenario#3', $scenarios[0]->getTitle());

        $this->assertTrue($scenarios[0] instanceof OutlineNode);
        $this->assertTrue($scenarios[0]->hasExamples());
        $this->assertEquals([
            ['action' => 'act#1', 'outcome' => 'out#1'],
        ], $scenarios[0]->getExampleTable()->getColumnsHash());

        /*****************
         *    Node 4    *
         ****************/
        $filter = new PartialRunnerFilter(4, 3);
        $feature = $filter->filterFeature($this->getParsedFeature());
        $scenarios = $feature->getScenarios();

        $this->assertEquals(count($scenarios), 1);
        $this->assertEquals('Scenario#3', $scenarios[0]->getTitle());

        $this->assertTrue($scenarios[0] instanceof OutlineNode);
        $this->assertTrue($scenarios[0]->hasExamples());
        $this->assertEquals([
            ['action' => 'act#2', 'outcome' => 'out#2'],
        ], $scenarios[0]->getExampleTable()->getColumnsHash());
    }
}
