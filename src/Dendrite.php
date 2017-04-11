<?php

namespace Alcalyn\NeuralNetwork;

class Dendrite
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var Neuron
     */
    public $neuronFrom;

    /**
     * @var Neuron
     */
    public $neuron;

    /**
     * @var float
     */
    public $w;
}
