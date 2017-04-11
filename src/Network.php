<?php

namespace Alcalyn\NeuralNetwork;

class Network
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var float
     */
    public $e = 0.5;

    /**
     * @var array
     */
    public $structure;

    /**
     * @var Layer[]
     */
    public $layers;

    /**
     * @param array $structure
     */
    public function __construct(array $structure)
    {
        $this->structure = $structure;
        $this->layers = [];

        foreach ($structure as $size) {
            $this->layers []= new Layer($size);
        }

        $this->linkLayers();
    }

    /**
     * @param float[] $in
     *
     * @return float[]
     */
    public function pulseInput(array $in)
    {
        $this->setInput($in);
        $this->pulse();

        return $this->getOutput();
    }

    /**
     * Pulse.
     */
    public function pulse()
    {
        for ($i = 1; $i < count($this->structure); $i++) {
            $this->layers[$i]->pulse();
        }
    }

    /**
     * @param float[] $in
     * @param float[] $expected
     *
     * @return float[]
     */
    public function trainInput(array $in, array $expected)
    {
        if ($this->getInputLayer()->size !== count($in)) {
            throw new RuntimeException('Input array length must be the same as input length.');
        }

        if ($this->getOutputLayer()->size !== count($expected)) {
            throw new RuntimeException('Expected array length must be the same as output length.');
        }

        $out = $this->pulseInput($in);

        $layer = $this->getOutputLayer();

        for ($i = 0; $i < $layer->size; $i++) {
            $neuron = $layer->neurons[$i];
            $neuron->gradiant = $neuron->axion * (1 - $neuron->axion) * ($expected[$i] - $neuron->axion);
        }

        for ($j = count($this->structure) - 2; $j >= 1; $j--) {
            $layer = $this->layers[$j];

            foreach ($layer->neurons as $neuron) {
                $sum = 0;

                foreach ($neuron->succ as $succ) {
                    $sum += $succ->neuronFrom->gradiant * $succ->w;
                }

                $neuron->gradiant = $neuron->axion * (1 - $neuron->axion) * $sum;
            }
        }

        for ($j = 1; $j < count($this->structure); $j++) {
            foreach ($this->layers[$j]->neurons as $neuron) {
                foreach ($neuron->dendrites as $dendrite) {
                    $dendrite->w += $this->e * $neuron->gradiant * $dendrite->neuron->axion;
                }
            }
        }

        return $out;
    }

    /**
     * Link layers together.
     */
    public function linkLayers()
    {
        for ($i = 1; $i < count($this->structure); $i++) {
            $this->layers[$i]->bind($this->layers[$i - 1]);
        }
    }

    /**
     * @param float[] $in
     *
     * @throws RuntimeException
     */
    public function setInput(array $in)
    {
        if ($this->getInputLayer()->size !== count($in)) {
            throw new RuntimeException('Input array length must be the same as input length.');
        }

        for ($i = 0; $i < $this->structure[0]; $i++) {
            $this->getInputLayer()->neurons[$i]->axion = $in[$i];
        }
    }

    /**
     * @return float[]
     */
    public function getOutput()
    {
        $output = [];

        foreach ($this->getOutputLayer()->neurons as $neuron) {
            $output []= $neuron->axion;
        }

        return $output;
    }

    /**
     * @return Layer
     */
    public function getInputLayer()
    {
        return $this->layers[0];
    }

    /**
     * @return Layer
     */
    public function getOutputLayer()
    {
        return $this->layers[count($this->layers) - 1];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $output = '';
        $layerCount = 0;

        foreach ($this->layers as $layer) {
            $output .= PHP_EOL.'   Layer '.$layerCount.PHP_EOL.PHP_EOL;

            foreach ($layer->neurons as $neuron) {
                $output .= 'Neuron'.PHP_EOL;

                if ($layerCount > 0) {
                    foreach ($neuron->dendrites as $dendrite) {
                        $output .= 'x ='.self::f($dendrite->neuron->axion).'   ';
                    }

                    $output .= PHP_EOL;

                    foreach ($neuron->dendrites as $dendrite) {
                        $output .= 'w ='.self::f($dendrite->w).'   ';
                    }

                    $output .= PHP_EOL;
                }

                $output .= 'Axion ='.self::f($neuron->axion).PHP_EOL.PHP_EOL;
            }

            $layerCount++;
        }

        return $output.PHP_EOL;
    }

    private static function f($float)
    {
        return ($float >= 0 ? ' ' : '').number_format($float, 3, '.', '');
    }
}
