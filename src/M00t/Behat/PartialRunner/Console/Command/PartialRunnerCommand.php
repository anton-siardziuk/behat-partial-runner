<?php

namespace M00t\Behat\PartialRunner\Console\Command;

use Behat\Behat\Console\Command\BehatCommand;
use Behat\Gherkin\Gherkin;
use M00t\Behat\PartialRunner\FeatureDivider;

class PartialRunnerCommand extends BehatCommand
{
    private $countWorkers;
    private $workerNumber;

    public function setCountWorkers($countWorkers)
    {
        $this->countWorkers = $countWorkers;
    }

    public function setWorkerNumber($workerNumber)
    {
        $this->workerNumber = $workerNumber;
    }

    protected function runFeatures(Gherkin $gherkin)
    {
        $features = array();
        foreach ($this->getFeaturesPaths() as $path) {
            // parse every feature with Gherkin
            $features += $gherkin->load((string) $path);
        }

        $divider = new FeatureDivider($features);
        $divider->setPartsCount($this->countWorkers);

        $features = $divider->getFeaturesForPart($this->workerNumber);

        // and run it in FeatureTester
        foreach ($features as $feature) {
            $tester = $this->getContainer()->get('behat.tester.feature');
            $tester->setSkip($this->isDryRun());

            $feature->accept($tester);
        }
    }
}