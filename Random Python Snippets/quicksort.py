import random


def quicksort(array):
    if len(array) <= 1:
        return array
    i = random.randint(0, len(array) - 1)
    array[0], array[i] = array[i], array[0]
    pivot, lp, rp = 0, 1, len(array) - 1

    while lp < rp:
        if array[lp] > array[pivot] and array[rp] < array[pivot]:
            array[lp], array[rp] = array[rp], array[lp]
        lp += 1 if array[lp] <= array[pivot] else 0
        rp -= 1 if array[rp] >= array[pivot] else 0
    if array[rp] < array[pivot]:
        array[pivot], array[rp] = array[rp], array[pivot]
    else:
        array[pivot], array[rp - 1] = array[rp - 1], array[pivot]

    array[:rp] = quicksort(array[:rp])
    array[rp:] = quicksort(array[rp:])
    return array


def test():
    myArray = [5, 5, 2, 4, 16, 15, 20, 1, 18, 10, 21, 51, 41, 31]
    print("old", myArray)
    myArray = quicksort(myArray)
    print("new", myArray)


test()
