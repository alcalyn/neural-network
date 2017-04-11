<?php

namespace Alcalyn\NeuralNetwork;

class Layer
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $size;

    /**
     * @var Neuron[]
     */
    public $neurons;

    /**
     * @param int $size
     */
    public function __construct($size)
    {
        $this->size = $size;
        $this->neurons = [];

        for ($i = 0; $i < $size; $i++) {
            $this->neurons []= new Neuron();
        }
    }

    /**
     * Pulse.
     */
    public function pulse()
    {
        foreach ($this->neurons as $neuron) {
            $neuron->pulse();
        }
    }

    /**
     * @param Layer $layer
     */
    public function bind(Layer $layer)
    {
        foreach ($this->neurons as $neuron) {
            foreach ($layer->neurons as $neuronPred) {
                $neuron->bind($neuronPred);
            }
        }
    }
}
