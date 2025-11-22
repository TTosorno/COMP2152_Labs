package sut;

import java.time.LocalDate;
import java.time.temporal.ChronoUnit;

public final class DateToolkit {
    private DateToolkit() {}

    // Absolute days between dates (inclusive-exclusive): daysBetween(2024-01-01, 2024-01-02) == 1
    public static long daysBetween(LocalDate a, LocalDate b) {
        return Math.abs(ChronoUnit.DAYS.between(a, b));
    }

    // Gregorian leap year rule
    public static boolean isLeapYear(int y) {
        return (y % 400 == 0) ||
                ((y % 4 == 0) && (y % 100 != 0));
    }

    // True if two date ranges [s1,e1] and [s2,e2] overlap (inclusive).
    // If any start> end -> IllegalArgumentException
    public static boolean overlaps(LocalDate s1, LocalDate e1, LocalDate s2, LocalDate e2) {
        if (s1.isAfter(e1) || s2.isAfter(e2)) throw new IllegalArgumentException("bad range");
        return !e1.isBefore(s2) && !e2.isBefore(s1);
    }
}