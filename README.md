Neural network
==============

Create a multilayer perceptron and make it learn.


## Usage

``` php
# Creates a new multilayer perceptron
$network = new Network([2, 4, 1]);

# Takes an input and let it cogitate
$network->pulseInput([1, 0]); # Returns an array as output

# Takes an array of tuples input/expected output
# and adjust the network one iteration to adapt the output the expected result
$network->trainInput([[1, 0], [1]]); # Returns an array as output
```


## Examples

 - [Learning logical gate](examples/learn-logical-gate)
 - [Number recognition](examples/number-recognition)


## License

This library is under [MIT License](LICENSE).
