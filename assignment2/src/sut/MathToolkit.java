package sut;

public final class MathToolkit {
    private MathToolkit() {}

    // Factorial for 0..12 (fits in int).
    // n<0 or n>12 -> IllegalArgumentException
    public static int factorial(int n) {
        if (n < 0 || n > 12) throw new IllegalArgumentException("n out of range");
        int r = 1;
        for (int i = 2; i <= n; i++) r *= i;
        return r;
    }

    // Mean of an int array as double;
    // empty or null -> IllegalArgumentException
    public static double mean(int[] arr) {
        if (arr == null || arr.length == 0) throw new IllegalArgumentException("empty");
        long sum = 0;
        for (int v : arr) sum += v;
        return (double) sum / arr.length;
    }

    // Clamp v to [min, max];
    // if min>max -> IllegalArgumentException
    public static int clamp(int v, int min, int max) {
        if (min > max) throw new IllegalArgumentException("min>max");
        if (v < min) return min;
        if (v > max) return max;
        return v;
    }
}