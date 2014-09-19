<?php


namespace M00t\Behat\PartialRunner\Filter;


use Behat\Gherkin\Filter\SimpleFilter;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;

class PartialRunnerFilter extends SimpleFilter
{
    private $countWorkers;
    private $workerNumber;
    private $curScenario;

    public function __construct($countWorkers, $workerNumber)
    {
        $this->countWorkers = $countWorkers;
        $this->workerNumber = $workerNumber;
        $this->curScenario = 0;
    }

    public function isFeatureMatch(FeatureNode $feature)
    {
        return false;
    }

    /**
     * Checks if scenario or outline matches specified filter.
     *
     * @param ScenarioInterface $scenario Scenario or Outline node instance
     *
     * @return Boolean
     */
    public function isScenarioMatch(ScenarioInterface $scenario)
    {
        $this->curScenario++;
        return $this->curScenario % $this->countWorkers === $this->workerNumber;
    }

}