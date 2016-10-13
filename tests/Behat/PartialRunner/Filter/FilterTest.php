<?php namespace Tests\Behat\ParallelRunner\Filter;

use Behat\Gherkin\Keywords\ArrayKeywords;
use Behat\Gherkin\Lexer;
use Behat\Gherkin\Parser;
use PHPUnit\Framework\TestCase;

/**
 * Class FilterTest.
 *
 * Base class for filter testing which sets up a Gherking Feature with several scenarios and a parser.
 */
abstract class FilterTest extends TestCase
{
    /**
     * @return Parser
     */
    protected function getParser()
    {
        return new Parser(
            new Lexer(
                new ArrayKeywords([
                    'en' => [
                        'feature'          => 'Feature',
                        'background'       => 'Background',
                        'scenario'         => 'Scenario',
                        'scenario_outline' => 'Scenario Outline|Scenario Template',
                        'examples'         => 'Examples|Scenarios',
                        'given'            => 'Given',
                        'when'             => 'When',
                        'then'             => 'Then',
                        'and'              => 'And',
                        'but'              => 'But',
                    ],
                ])
            )
        );
    }

    /**
     * @return string
     */
    protected function getGherkinFeature()
    {
        return <<<'GHERKIN'
Feature: Long feature with outline
  In order to accomplish objective
  As a someone
  I have to be able to do something

  Scenario: Scenario#1
    Given initial step
    When action occurs
    Then outcomes should be visible

  Scenario: Scenario#2
    Given initial step
    And another initial step
    When action occurs
    Then outcomes should be visible

  Scenario Outline: Scenario#3
    When <action> occurs
    Then <outcome> should be visible

    Examples:
      | action | outcome |
      | act#1  | out#1   |
      | act#2  | out#2   |
      | act#3  | out#3   |

  Scenario: Scenario#4
    When an occurs
    Then the outcome should be visible
GHERKIN;
    }

    /**
     * @return \Behat\Gherkin\Node\FeatureNode|null
     */
    protected function getParsedFeature()
    {
        return $this->getParser()->parse($this->getGherkinFeature());
    }
}
