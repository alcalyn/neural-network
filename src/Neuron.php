<?php

namespace Alcalyn\NeuralNetwork;

class Neuron
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var Dendrite[]
     */
    public $dendrites;

    /**
     * @var float
     */
    public $axion;

    /**
     * @var float
     */
    public $gradiant;

    /**
     * @var Dendrite[]
     */
    public $succ;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->dendrites = [];
        $this->axion = 0;
        $this->succ = [];
    }

    /**
     * Pulse.
     */
    public function pulse()
    {
        $sum = 0;

        foreach ($this->dendrites as $dendrite) {
            $sum += $dendrite->neuron->axion * $dendrite->w;
        }

        $this->axion = self::sig($sum);
    }

    /**
     * @param Neuron $neuron
     */
    public function bind(Neuron $neuron)
    {
        $dendrite = new Dendrite();

        $dendrite->neuronFrom = $this;
        $dendrite->neuron = $neuron;
        $dendrite->w = rand(-5, 5) / 10;

        $this->dendrites []= $dendrite;

        $neuron->succ []= $dendrite;
    }

    /**
     * @param float $n
     *
     * @return float
     */
    public static function sig($n)
    {
        return 1 / (1 + exp(-$n));
    }
}
