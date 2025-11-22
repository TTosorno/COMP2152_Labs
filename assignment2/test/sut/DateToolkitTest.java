package sut;

import org.junit.jupiter.api.Test;

import java.time.LocalDate;
import static org.junit.jupiter.api.Assertions.*;

class DateToolkitTest {

    private final LocalDate JAN_1 = LocalDate.of(2025, 1, 1);
    private final LocalDate JAN_2 = LocalDate.of(2025, 1, 2);
    private final LocalDate JAN_31 = LocalDate.of(2025, 1, 31);

    @Test
    void daysBetween_sameDay_returnsZero() {
        assertEquals(0, DateToolkit.daysBetween(JAN_1, JAN_1));
    }

    @Test
    void daysBetween_adjacentDays_returnsOne() {
        assertEquals(1, DateToolkit.daysBetween(JAN_1, JAN_2));
    }

    @Test
    void daysBetween_reversedOrder_returnsAbsoluteDifference() {
        assertEquals(30, DateToolkit.daysBetween(JAN_31, JAN_1));
    }

    @Test
    void isLeapYear_divisibleBy400_returnsTrue() {
        assertTrue(DateToolkit.isLeapYear(2000));
    }

    @Test
    void isLeapYear_divisibleBy100ButNot400_returnsFalse() {
        assertFalse(DateToolkit.isLeapYear(1900));
    }

    @Test
    void isLeapYear_divisibleBy4ButNot100_returnsTrue() {
        assertTrue(DateToolkit.isLeapYear(2004));
    }

    @Test
    void isLeapYear_notDivisibleBy4_returnsFalse() {
        assertFalse(DateToolkit.isLeapYear(2003));
    }

    @Test
    void overlaps_validOverlap_returnsTrue() {
        LocalDate s1 = JAN_1;
        LocalDate e1 = JAN_31;
        LocalDate s2 = LocalDate.of(2025, 1, 15);
        LocalDate e2 = LocalDate.of(2025, 2, 15);
        assertTrue(DateToolkit.overlaps(s1, e1, s2, e2));
    }

    @Test
    void overlaps_noOverlap_returnsFalse() {
        LocalDate s1 = JAN_1;
        LocalDate e1 = LocalDate.of(2025, 1, 10);
        LocalDate s2 = LocalDate.of(2025, 1, 15);
        LocalDate e2 = JAN_31;
        assertFalse(DateToolkit.overlaps(s1, e1, s2, e2));
    }

    @Test
    void overlaps_touchingEnds_returnsTrue() {
        LocalDate s1 = JAN_1;
        LocalDate e1 = LocalDate.of(2025, 1, 10);
        LocalDate s2 = LocalDate.of(2025, 1, 10);
        LocalDate e2 = LocalDate.of(2025, 1, 20);
        assertTrue(DateToolkit.overlaps(s1, e1, s2, e2));
    }

    @Test
    void overlaps_badRange_throwsIllegalArgumentException() {
        LocalDate s1 = JAN_31;
        LocalDate e1 = JAN_1;
        assertThrows(IllegalArgumentException.class, () -> {
            DateToolkit.overlaps(s1, e1, JAN_1, JAN_2);
        });
    }
}