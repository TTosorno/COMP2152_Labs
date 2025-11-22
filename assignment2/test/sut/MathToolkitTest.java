package sut;

import org.junit.jupiter.api.Test;

import static org.junit.jupiter.api.Assertions.*;

class MathToolkitTest {

    @Test
    void factorial_zero_returnsOne() {
        assertEquals(1, MathToolkit.factorial(0));
    }

    @Test
    void factorial_validInput_returnsCorrectResult() {
        assertEquals(120, MathToolkit.factorial(5));
    }

    @Test
    void factorial_boundaryInput_returnsCorrectResult() {
        assertEquals(479001600, MathToolkit.factorial(12));
    }

    @Test
    void factorial_negativeInput_throwsIllegalArgumentException() {
        assertThrows(IllegalArgumentException.class, () -> {
            MathToolkit.factorial(-1);
        });
    }

    @Test
    void factorial_inputOver12_throwsIllegalArgumentException() {
        assertThrows(IllegalArgumentException.class, () -> {
            MathToolkit.factorial(13);
        });
    }

    @Test
    void mean_nullArray_throwsIllegalArgumentException() {
        assertThrows(IllegalArgumentException.class, () -> {
            MathToolkit.mean(null);
        });
    }

    @Test
    void mean_emptyArray_throwsIllegalArgumentException() {
        assertThrows(IllegalArgumentException.class, () -> {
            MathToolkit.mean(new int[]{});
        });
    }

    @Test
    void mean_validArray_returnsCorrectMean() {
        assertEquals(3.0, MathToolkit.mean(new int[]{1, 2, 3, 4, 5}));
    }

    @Test
    void clamp_valueBelowMin_returnsMin() {
        assertEquals(10, MathToolkit.clamp(5, 10, 20));
    }

    @Test
    void clamp_valueAboveMax_returnsMax() {
        assertEquals(20, MathToolkit.clamp(25, 10, 20));
    }

    @Test
    void clamp_valueInRange_returnsValue() {
        assertEquals(15, MathToolkit.clamp(15, 10, 20));
    }

    @Test
    void clamp_minGreaterThanMax_throwsIllegalArgumentException() {
        assertThrows(IllegalArgumentException.class, () -> {
            MathToolkit.clamp(15, 20, 10);
        });
    }
}