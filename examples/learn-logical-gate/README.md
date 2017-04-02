Learning logical gate
=====================

In this basic example, we make a neural network learn to reproduce logical gates.

Theorically, a 2-4-1 network can learn all 16 logical gates. This is what we do here.

The 2 input perceptron is the gate input, and the one perceptron is the gate output.

This example learn a network to reproduce the `xor` gate,
returns `1` only if only one of the input is `1`, but not both.

It runs 50000 iteration, and decrease the network rigidity (`e`) a little, at every iteration.


## Run the example

``` bash
php test-binaire.php
```
