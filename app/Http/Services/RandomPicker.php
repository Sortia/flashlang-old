<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * Picks a random element from a number of weighted element.
 *
 * Elements can be of any type. Weights must be positive integers.
 */
class RandomPicker
{
    /**
     * The elements to be randomized.
     */
    private array $elements = [];

    /**
     * The weights for each element, using common keys.
     */
    private array $weights = [];

    /**
     * The sum of all the weights.
     */
    private int $totalWeight = 0;

    /**
     * Whether the weights array is sorted by descending weight.
     *
     * Sorting is not necessary for the algorithm to return correct results,
     * but it greatly improves performance for large arrays. Sorting is performed
     * just-in-time when calling getRandomElement().
     */
    private bool $isSorted = true;

    /**
     * Adds a single element.
     *
     * @param mixed $value
     * @throws InvalidArgumentException If the weight is not a positive integer.
     */
    public function addElement($value, int $weight): void
    {
        if ($weight < 1) {
            throw new InvalidArgumentException('Weight must be a positive integer.');
        }

        $this->elements[] = $value;
        $this->weights[] = $weight;
        $this->totalWeight += $weight;
        $this->isSorted = false;
    }

    /**
     * Adds an associative array of elements.
     * The keys are elements, the values are weights.
     *
     * @throws InvalidArgumentException If a weight is not a positive integer.
     */
    public function addElements(Collection $elements): void
    {
        $elements->each(fn($weight, $value) => $this->addElement($value, $weight));
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function getRandomElement()
    {
        if (!$this->isSorted) {
            arsort($this->weights);
            $this->isSorted = true;
        }

        if ($this->totalWeight !== 0) {
            $value = random_int(1, $this->totalWeight);

            foreach ($this->weights as $key => $weight) {
                $value -= $weight;

                if ($value <= 0) {
                    return $this->elements[$key];
                }
            }
        }
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function getWeights()
    {
        return $this->weights;
    }
}
