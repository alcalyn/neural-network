Number recognition
==================

This network will learn to recognize a number in a image (bit matrix).

It take at input each pixel of the image, in serial.
It outputs 11 bits: one for each number, the last one for "not a number".

It should output for example:

`10000000000`: It's a zero
`00000100000`: It's a fize
`00000000001`: It's not a number
`00000000000`: I didn't recognized anything

The aim is to maximize the success percentage.

This example will first learn on a sample by iterating on it.

Then it will try to recognize numbers on new images, not in samples.


## Run the example

``` bash
# At first time, parse sample png images to dump as PHP array
php parse-samples.php

# Learn on samples and try to recognize new images
php test-numbers.php
```
