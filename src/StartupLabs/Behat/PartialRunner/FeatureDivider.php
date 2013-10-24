<?php

namespace StartupLabs\Behat\PartialRunner;


class FeatureDivider {

    private $features;
    private $partsCount;

    public function __construct($features)
    {
        $this->features = $features;
    }

    public function setPartsCount($count)
    {
        $this->partsCount = $count;
    }

    public function getFeaturesForPart($part)
    {
        if (is_null($this->partsCount)) {
            throw new Exception('Parts count is not set');
        }

        if ($this->partsCount <= $part) {
            throw new Exception('Requested part should be less than parts count');
        }

        $featuresPerPart = floor(count($this->features) / $this->partsCount);

        $featuresRest = count($this->features) - $featuresPerPart * $this->partsCount;

        $skip = 0;
        for ($i = 0; $i < $part; $i++) {
            $skip += $featuresPerPart;
            if ($i < $featuresRest) {
                $skip++;
            }
        }

        $thisPart = $featuresPerPart;
        if ($part < $featuresRest) {
            $thisPart++;
        }
        return array_slice($this->features, $skip, $thisPart);
    }
}